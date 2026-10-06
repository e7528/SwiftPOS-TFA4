<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Customer Accounts</h2>
        <p class="text-secondary mb-0">Registered patrons and point-of-sale customer profiles.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-white text-secondary border px-3 py-2 rounded-3 shadow-sm">
            <i class="bi bi-people me-1 text-primary"></i> <?= esc(count($customers ?? [])) ?> Total Records
        </span>
        <a class="btn btn-primary" href="<?= esc(site_url('customers/new'), 'attr') ?>">
            <i class="bi bi-plus-lg me-1"></i> New Customer
        </a>
    </div>
</div>

<?php if ($success = session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="status"><?= esc($success) ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4 py-3" style="width: 100px;">Account ID</th>
                    <th class="py-3">Customer</th>
                    <th class="py-3">Email Address</th>
                    <th class="py-3">Contact Number</th>
                    <th class="py-3 text-end">Status</th>
                    <th class="py-3 text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers) && is_array($customers)): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border font-monospace">#<?= esc($customer['id']) ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="avatar-circle bg-primary-subtle text-primary">
                                        <?= esc(strtoupper(substr((string) $customer['full_name'], 0, 1))) ?>
                                    </span>
                                    <span class="fw-semibold text-dark"><?= esc($customer['full_name']) ?></span>
                                </div>
                            </td>
                            <td>
                                <a href="<?= esc('mailto:' . $customer['email'], 'attr') ?>" class="text-decoration-none text-secondary">
                                    <i class="bi bi-envelope me-1 text-muted"></i><?= esc($customer['email']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="text-secondary font-monospace small">
                                    <i class="bi bi-telephone me-1 text-muted"></i><?= esc(($customer['phone'] ?? null) === null || trim((string) $customer['phone']) === '' ? 'null' : $customer['phone']) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <?php
                                    $statusClass = strtolower((string) $customer['status']) === 'active'
                                        ? 'bg-success-subtle text-success'
                                        : 'bg-secondary-subtle text-secondary';
                                ?>
                                <span class="badge rounded-pill px-2 py-1 <?= esc($statusClass, 'attr') ?>">
                                    <?= esc($customer['status']) ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a class="btn btn-sm btn-outline-primary" href="<?= esc(site_url('customers/' . (int) $customer['id'] . '/edit'), 'attr') ?>" aria-label="Edit <?= esc($customer['full_name'], 'attr') ?>">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                            No customer records found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
