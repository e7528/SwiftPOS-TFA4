<?php
    helper('form');
    $isEdit = ($mode ?? 'new') === 'edit';
    $values = array_replace($customer ?? [], $values ?? []);
    $errors = $errors ?? [];
    $formAction = $isEdit
        ? site_url('customers/' . (int) ($customer['id'] ?? 0))
        : site_url('customers');
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1"><?= esc($isEdit ? 'Edit Customer' : 'New Customer') ?></h2>
        <p class="text-secondary mb-0">Enter the customer account details below.</p>
    </div>
    <a class="btn btn-outline-secondary" href="<?= esc(site_url('customers'), 'attr') ?>">
        <i class="bi bi-arrow-left me-1"></i> Back to Customers
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <?php if ($errors !== []): ?>
            <div class="alert alert-danger" role="alert">
                <p class="fw-semibold mb-1">Please correct the following:</p>
                <ul class="mb-0">
                    <?php foreach ($errors as $message): ?>
                        <li><?= esc($message) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= esc($formAction, 'attr') ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="full_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="full_name" name="full_name" maxlength="100" required
                           class="form-control<?= isset($errors['full_name']) ? ' is-invalid' : '' ?>"
                           value="<?= esc($values['full_name'] ?? '', 'attr') ?>"
                           <?= isset($errors['full_name']) ? 'aria-invalid="true" aria-describedby="full_name_error"' : '' ?>>
                    <?php if (isset($errors['full_name'])): ?>
                        <div id="full_name_error" class="invalid-feedback"><?= esc($errors['full_name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" maxlength="100" required
                           class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                           value="<?= esc($values['email'] ?? '', 'attr') ?>"
                           <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="email_error"' : '' ?>>
                    <?php if (isset($errors['email'])): ?>
                        <div id="email_error" class="invalid-feedback"><?= esc($errors['email']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">Contact Number</label>
                    <input type="tel" id="phone" name="phone" maxlength="25"
                           class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>"
                           value="<?= esc($values['phone'] ?? '', 'attr') ?>"
                           <?= isset($errors['phone']) ? 'aria-invalid="true" aria-describedby="phone_error"' : '' ?>>
                    <?php if (isset($errors['phone'])): ?>
                        <div id="phone_error" class="invalid-feedback"><?= esc($errors['phone']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" required
                            class="form-select<?= isset($errors['status']) ? ' is-invalid' : '' ?>"
                            <?= isset($errors['status']) ? 'aria-invalid="true" aria-describedby="status_error"' : '' ?>>
                        <option value="">Choose a status</option>
                        <?php foreach (['Active', 'Inactive'] as $status): ?>
                            <option value="<?= esc($status, 'attr') ?>" <?= ($values['status'] ?? 'Active') === $status ? 'selected' : '' ?>>
                                <?= esc($status) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['status'])): ?>
                        <div id="status_error" class="invalid-feedback"><?= esc($errors['status']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Password<?= $isEdit ? '' : ' <span class="text-danger">*</span>' ?></label>
                    <input type="password" id="password" name="password" autocomplete="new-password"
                           <?= $isEdit ? '' : 'required' ?>
                           class="form-control<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                           <?= isset($errors['password']) ? 'aria-invalid="true" aria-describedby="password_help password_error"' : 'aria-describedby="password_help"' ?>>
                    <div id="password_help" class="form-text">
                        <?= esc($isEdit ? 'Leave blank to keep the current password.' : 'Choose a password for the new customer.') ?>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <div id="password_error" class="invalid-feedback"><?= esc($errors['password']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> <?= esc($isEdit ? 'Save Changes' : 'Create Customer') ?>
                </button>
                <a class="btn btn-outline-secondary" href="<?= esc(site_url('customers'), 'attr') ?>">Cancel</a>
            </div>
        </form>
    </div>
</div>
