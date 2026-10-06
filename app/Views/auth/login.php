<div class="row justify-content-center py-4 py-md-5">
    <div class="col-md-7 col-lg-5">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4 p-md-5">
                <span class="badge rounded-pill bg-primary-subtle text-primary mb-3">STAFF ACCESS</span>
                <h1 class="h3 fw-bold mb-2">Sign in to SwiftPOS</h1>
                <p class="text-secondary mb-4">Manage customer and staff accounts with your username and password.</p>
                <?php if ($error = session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert"><?= esc($error) ?></div>
                <?php endif; ?>
                <form method="post" action="<?= esc(site_url('login'), 'attr') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="username">Username</label>
                        <input class="form-control" id="username" name="username" type="text"
                               autocomplete="username" maxlength="50" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password"
                               autocomplete="current-password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Log in</button>
                </form>
            </div>
        </div>
    </div>
</div>
