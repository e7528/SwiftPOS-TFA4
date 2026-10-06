#!/usr/bin/env python3
"""Run against a local SwiftPOS instance with an existing staff account.

Requires SWIFTPOS_TEST_USERNAME and SWIFTPOS_TEST_PASSWORD in the environment.
This script reads data and tests authentication; it does not create or edit accounts.
"""

import os
import sys
from html.parser import HTMLParser
from http.cookiejar import CookieJar
from urllib.error import HTTPError
from urllib.parse import urlencode, urljoin, urlsplit
from urllib.request import HTTPCookieProcessor, HTTPRedirectHandler, Request, build_opener


class NoRedirect(HTTPRedirectHandler):
    def redirect_request(self, request, fp, code, msg, headers, newurl):
        return None


class FormToken(HTMLParser):
    def __init__(self, form_path):
        super().__init__()
        self.form_path = form_path
        self.in_form = False
        self.token = None

    def handle_starttag(self, tag, attrs):
        attributes = dict(attrs)
        if tag == "form":
            self.in_form = urlsplit(attributes.get("action", "")).path.rstrip("/").endswith(self.form_path)
        elif tag == "input" and self.in_form and attributes.get("type") == "hidden":
            if attributes.get("name") not in (None, "is_verified"):
                self.token = (attributes["name"], attributes.get("value", ""))

    def handle_endtag(self, tag):
        if tag == "form":
            self.in_form = False


def csrf_field(html, form_path):
    parser = FormToken(form_path)
    parser.feed(html)
    assert parser.token is not None, f"CSRF field missing from {form_path} form"
    return parser.token


def main(base, username, password):
    base = base.rstrip("/") + "/"
    opener = build_opener(HTTPCookieProcessor(CookieJar()), NoRedirect())

    def request(path, fields=None):
        url = urljoin(base, path)
        body = None if fields is None else urlencode(fields).encode("utf-8")
        try:
            response = opener.open(Request(url, data=body), timeout=15)
        except HTTPError as error:
            response = error
        with response:
            return response.status, response.headers.get("Location", ""), response.read().decode("utf-8", "replace")

    def is_login_redirect(result):
        status, location, _ = result
        path = urlsplit(urljoin(base, location)).path.rstrip("/")
        assert status in (302, 303) and path.endswith("/login"), (status, location)

    status, _, login = request("login")
    assert status == 200 and "Sign in to SwiftPOS" in login

    for path in ("customers", "customers/new", "customers/999999/edit",
                 "users", "users/new", "users/999999/edit"):
        is_login_redirect(request(path))
    print("PASS: logged-out visitors cannot open account lists or forms")

    token_name, token_value = csrf_field(login, "/login")
    is_login_redirect(request("login", {
        token_name: token_value, "username": username, "password": password + "invalid",
    }))
    status, _, login = request("login")
    assert status == 200 and "Invalid username or password" in login
    print("PASS: invalid password is refused")

    token_name, token_value = csrf_field(login, "/login")
    status, location, _ = request("login", {
        token_name: token_value, "username": username, "password": password,
    })
    assert status in (302, 303) and urlsplit(urljoin(base, location)).path.rstrip("/").endswith("/customers"), (status, location)

    for path in ("customers", "customers/new", "users", "users/new"):
        status, _, html = request(path)
        assert status == 200 and "Log out" in html, (path, status)
    print("PASS: authenticated staff can open both account lists and forms")

    token_name, token_value = csrf_field(html, "/logout")
    is_login_redirect(request("logout", {token_name: token_value}))
    is_login_redirect(request("customers"))
    print("PASS: logout destroys access to protected pages")


if __name__ == "__main__":
    if len(sys.argv) != 2 or not os.environ.get("SWIFTPOS_TEST_USERNAME") or not os.environ.get("SWIFTPOS_TEST_PASSWORD"):
        sys.exit("Usage: SWIFTPOS_TEST_USERNAME=... SWIFTPOS_TEST_PASSWORD=... python3 scripts/smoke_auth.py http://localhost:8080/")
    main(sys.argv[1], os.environ["SWIFTPOS_TEST_USERNAME"], os.environ["SWIFTPOS_TEST_PASSWORD"])
