<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SwiftPOS System') ?></title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-body-font-family: 'Inter', system-ui, -apple-system, sans-serif;
            --bs-body-bg: #f8fafc;
            --bs-body-color: #334155;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .card {
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .avatar-image,
        .avatar-preview {
            border-radius: 50%;
            object-fit: cover;
            background-color: #f1f5f9;
            flex-shrink: 0;
        }
        .avatar-image {
            width: 36px;
            height: 36px;
        }
        .avatar-preview {
            width: 72px;
            height: 72px;
        }
        .table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            border-top: none;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom border-secondary border-opacity-25 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-white" href="<?= site_url('/') ?>">
            <span class="badge bg-primary p-2 rounded-3"><i class="bi bi-shop-window"></i></span>
            <span>Swift<span class="text-primary">POS</span></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= site_url('/') ?>">
                        <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                    </a>
                </li>
                <?php if (session()->get('auth_user_id')): ?>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="<?= site_url('customers') ?>">
                            <i class="bi bi-people me-1"></i> Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="<?= site_url('users') ?>">
                            <i class="bi bi-person-badge me-1"></i> Staff Accounts
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= site_url('about') ?>">
                        <i class="bi bi-info-circle me-1"></i> System Info
                    </a>
                </li>
                <?php if (session()->get('auth_user_id')): ?>
                    <li class="nav-item d-flex align-items-center gap-2 px-3">
                        <span class="small text-white-50"><?= esc((string) session()->get('auth_username')) ?></span>
                        <form method="post" action="<?= esc(site_url('logout'), 'attr') ?>" class="m-0">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-light">Log out</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link px-3" href="<?= esc(site_url('login'), 'attr') ?>">Log in</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
