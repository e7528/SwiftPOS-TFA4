<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Terminal Dashboard</h2>
    <p class="text-secondary">Overview of current retail session, registered clients, and active terminal users.</p>
</div>

<!-- Key Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Customers</span>
                    <h3 class="fw-bold my-1 text-dark"><?= esc($customerCount) ?></h3>
                    <span class="text-success small fw-medium"><i class="bi bi-check2-circle"></i> Database Records</span>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Assigned Staff</span>
                    <h3 class="fw-bold my-1 text-dark"><?= esc($userCount) ?></h3>
                    <span class="text-primary small fw-medium"><i class="bi bi-shield-check"></i> <?= esc($roleCount) ?> Roles Configured</span>
                </div>
                <div class="bg-info-subtle text-info p-3 rounded-circle">
                    <i class="bi bi-person-badge-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Architecture</span>
                    <h3 class="fw-bold my-1 text-dark">MVC</h3>
                    <span class="text-muted small">CodeIgniter 4 Core</span>
                </div>
                <div class="bg-warning-subtle text-warning-emphasis p-3 rounded-circle">
                    <i class="bi bi-layers-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Data Layer</span>
                    <h3 class="fw-bold my-1 text-dark">MySQL</h3>
                    <span class="text-secondary small">Model-Backed Records</span>
                </div>
                <div class="bg-secondary-subtle text-secondary p-3 rounded-circle">
                    <i class="bi bi-database-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Shortcut Cards -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100 p-4 rounded-3 border-0 shadow-sm">
            <div class="d-flex align-items-start gap-3">
                <div class="bg-primary text-white p-3 rounded-3">
                    <i class="bi bi-person-lines-fill fs-3"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Customer Accounts</h4>
                    <p class="text-secondary small mb-3">View directory of clients, communication channels, and account identifier records.</p>
                    <a href="<?= esc(site_url('customers'), 'attr') ?>" class="btn btn-primary btn-sm px-3 fw-medium">
                        Open Customer List <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 p-4 rounded-3 border-0 shadow-sm">
            <div class="d-flex align-items-start gap-3">
                <div class="bg-dark text-white p-3 rounded-3">
                    <i class="bi bi-person-gear fs-3"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Staff Management</h4>
                    <p class="text-secondary small mb-3">Check assigned store staff, operational roles, and credential identities.</p>
                    <a href="<?= esc(site_url('users'), 'attr') ?>" class="btn btn-outline-dark btn-sm px-3 fw-medium">
                        Open Staff Directory <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
