<?php
    helper('form');
    $isEdit = ($mode ?? 'new') === 'edit';
    $user = $user ?? [];
    $values = array_replace($user, $values ?? []);
    $errors = $errors ?? [];
    $roleOptions = ['Admin', 'Store Manager', 'Cashier', 'Inventory'];
    $attendanceOptions = ['Clocked In', 'Clocked Out', 'PTO', 'AWOL'];
    $currentAvatar = trim((string) ($user['avatar'] ?? ''));
    $hasAvatar = preg_match('/^[a-f0-9]{32}\.(?:jpg|png)$/D', $currentAvatar) === 1;
    $avatarUrl = $hasAvatar
        ? base_url('uploads/avatars/' . rawurlencode($currentAvatar))
        : base_url('images/avatar-placeholder.svg');
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1"><?= esc($isEdit ? 'Edit Staff Account' : 'New Staff Account') ?></h2>
        <p class="text-secondary mb-0"><?= esc($isEdit ? 'Update this account and its optional profile picture.' : 'Create a staff account for a store operator.') ?></p>
    </div>
    <a class="btn btn-outline-secondary" href="<?= esc(site_url('users'), 'attr') ?>">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i> Back to Accounts
    </a>
</div>

<div class="card rounded-3">
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

        <form action="<?= esc(site_url($isEdit ? 'users/' . (int) ($user['id'] ?? 0) : 'users'), 'attr') ?>"
              method="post" <?= $isEdit ? 'enctype="multipart/form-data"' : '' ?> novalidate>
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                    <input id="username" name="username" type="text" maxlength="50" required
                           autocomplete="username" value="<?= esc((string) ($values['username'] ?? ''), 'attr') ?>"
                           class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                           <?= isset($errors['username']) ? 'aria-invalid="true" aria-describedby="username-error"' : '' ?>>
                    <?php if (isset($errors['username'])): ?>
                        <div id="username-error" class="invalid-feedback"><?= esc($errors['username']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="full_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input id="full_name" name="full_name" type="text" maxlength="100" required
                           autocomplete="name" value="<?= esc((string) ($values['full_name'] ?? ''), 'attr') ?>"
                           class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>"
                           <?= isset($errors['full_name']) ? 'aria-invalid="true" aria-describedby="full_name-error"' : '' ?>>
                    <?php if (isset($errors['full_name'])): ?>
                        <div id="full_name-error" class="invalid-feedback"><?= esc($errors['full_name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label fw-semibold">Assigned Role <span class="text-danger">*</span></label>
                    <select id="role" name="role" required
                            class="form-select <?= isset($errors['role']) ? 'is-invalid' : '' ?>"
                            <?= isset($errors['role']) ? 'aria-invalid="true" aria-describedby="role-error"' : '' ?>>
                        <option value="">Choose a role</option>
                        <?php foreach ($roleOptions as $role): ?>
                            <option value="<?= esc($role, 'attr') ?>" <?= ($values['role'] ?? '') === $role ? 'selected' : '' ?>><?= esc($role) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['role'])): ?>
                        <div id="role-error" class="invalid-feedback"><?= esc($errors['role']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="attendance_status" class="form-label fw-semibold">Attendance Status <span class="text-danger">*</span></label>
                    <select id="attendance_status" name="attendance_status" required
                            class="form-select <?= isset($errors['attendance_status']) ? 'is-invalid' : '' ?>"
                            <?= isset($errors['attendance_status']) ? 'aria-invalid="true" aria-describedby="attendance_status-error"' : '' ?>>
                        <option value="" <?= ($values['attendance_status'] ?? '') === '' ? 'selected' : '' ?>>Choose a status</option>
                        <?php foreach ($attendanceOptions as $attendance): ?>
                            <option value="<?= esc($attendance, 'attr') ?>" <?= ($values['attendance_status'] ?? 'Clocked Out') === $attendance ? 'selected' : '' ?>><?= esc($attendance) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['attendance_status'])): ?>
                        <div id="attendance_status-error" class="invalid-feedback"><?= esc($errors['attendance_status']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-12">
                    <label for="password" class="form-label fw-semibold">Password <?= $isEdit ? '<span class="text-muted fw-normal">(optional)</span>' : '<span class="text-danger">*</span>' ?></label>
                    <input id="password" name="password" type="password" minlength="12" maxlength="72"
                           autocomplete="new-password" <?= $isEdit ? '' : 'required' ?>
                           class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                           <?= isset($errors['password']) ? 'aria-invalid="true" aria-describedby="password-error"' : 'aria-describedby="password-help"' ?>>
                    <?php if (isset($errors['password'])): ?>
                        <div id="password-error" class="invalid-feedback"><?= esc($errors['password']) ?></div>
                    <?php else: ?>
                        <div id="password-help" class="form-text"><?= esc($isEdit ? 'Leave blank to keep the current password. A new password must have 12–72 characters.' : 'Use a password of 12–72 characters that is difficult to guess.') ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-12">
                    <input type="hidden" name="is_verified" value="0">
                    <div class="form-check">
                        <input id="is_verified" name="is_verified" type="checkbox" value="1"
                               class="form-check-input <?= isset($errors['is_verified']) ? 'is-invalid' : '' ?>"
                               <?= (string) ($values['is_verified'] ?? '0') === '1' ? 'checked' : '' ?>
                               <?= isset($errors['is_verified']) ? 'aria-invalid="true" aria-describedby="is_verified-error"' : '' ?>>
                        <label for="is_verified" class="form-check-label">Verified account</label>
                        <?php if (isset($errors['is_verified'])): ?>
                            <div id="is_verified-error" class="invalid-feedback"><?= esc($errors['is_verified']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($isEdit): ?>
                    <div class="col-12">
                        <label for="avatar" class="form-label fw-semibold d-block">Profile Picture</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="<?= esc($avatarUrl, 'attr') ?>" class="avatar-preview" width="72" height="72"
                                 alt="<?= esc($hasAvatar ? 'Current profile picture' : 'Default profile picture', 'attr') ?>">
                            <span class="text-secondary small"><?= esc($hasAvatar ? 'Current profile picture' : 'No profile picture uploaded yet.') ?></span>
                        </div>
                        <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png"
                               class="form-control <?= isset($errors['avatar']) ? 'is-invalid' : '' ?>"
                               <?= isset($errors['avatar']) ? 'aria-invalid="true" aria-describedby="avatar-error"' : 'aria-describedby="avatar-help"' ?>>
                        <?php if (isset($errors['avatar'])): ?>
                            <div id="avatar-error" class="invalid-feedback"><?= esc($errors['avatar']) ?></div>
                        <?php else: ?>
                            <div id="avatar-help" class="form-text">JPG or PNG, up to 2 MB and 4096 × 4096 pixels. Leave empty to keep the current picture.</div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> <?= esc($isEdit ? 'Save Changes' : 'Create Account') ?>
                </button>
                <a href="<?= esc(site_url('users'), 'attr') ?>" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
