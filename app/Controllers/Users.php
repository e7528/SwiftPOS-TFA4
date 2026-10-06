<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        $data = [
            'title' => 'User Accounts | SwiftPOS',
            'users' => $userModel
                ->select(['id', 'username', 'full_name', 'role', 'attendance_status', 'is_verified', 'avatar'])
                ->orderBy('id', 'ASC')
                ->findAll(),
        ];

        return view('templates/header', $data)
             . view('users/index', $data)
             . view('templates/footer');
    }

    public function newForm(): string
    {
        return $this->form('new', null, [
            'username' => '', 'full_name' => '', 'role' => 'Cashier',
            'attendance_status' => 'Clocked Out', 'is_verified' => '0',
        ]);
    }

    public function create(): string|RedirectResponse
    {
        $values = $this->postedValues();

        if (! $this->validateData($values, $this->rules('is_unique[users.username]', true))) {
            return $this->form('new', null, $values, $this->validator->getErrors());
        }

        $valid = $this->validator->getValidated();
        $model = new UserModel();
        $model->setValidationRule('username', 'required|max_length[50]|is_unique[users.username]');

        if ($model->insert([
            'username'          => $valid['username'],
            'full_name'         => $valid['full_name'],
            'role'              => $valid['role'],
            'attendance_status' => $valid['attendance_status'],
            'is_verified'       => $valid['is_verified'],
            'password'          => password_hash($valid['password'], PASSWORD_DEFAULT),
        ]) === false) {
            return $this->form('new', null, $values, $model->errors());
        }

        return redirect()->to(site_url('users'))->with('success', 'User created.');
    }

    public function edit(int $id): string
    {
        $user = $this->findOr404($id);

        return $this->form('edit', $user, [
            'username'          => $user['username'],
            'full_name'         => $user['full_name'],
            'role'              => $user['role'],
            'attendance_status' => $user['attendance_status'],
            'is_verified'       => (string) $user['is_verified'],
        ]);
    }

    public function update(int $id): string|RedirectResponse
    {
        $user     = $this->findOr404($id);
        $values   = $this->postedValues();
        $file     = $this->request->getFile('avatar');
        $upload   = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
        $unique   = 'is_unique[users.username,id,' . $id . ']';
        $rules    = $this->rules($unique, false);

        if ($upload) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]'
                . '|ext_in[avatar,jpg,jpeg,png]|max_size[avatar,2048]|max_dims[avatar,4096,4096]';
        }

        if (! $this->validateData($values, $rules)) {
            $errors = $this->validator->getErrors();

            if ($upload && ! $file->isValid()) {
                $errors['avatar'] = $file->getErrorString();
            }

            return $this->form('edit', $user, $values, $errors);
        }

        $valid = $this->validator->getValidated();
        $data  = [
            'username'          => $valid['username'],
            'full_name'         => $valid['full_name'],
            'role'              => $valid['role'],
            'attendance_status' => $valid['attendance_status'],
            'is_verified'       => $valid['is_verified'],
        ];

        if ($valid['password'] !== '') {
            $data['password'] = password_hash($valid['password'], PASSWORD_DEFAULT);
        }

        $newAvatar = null;

        if ($upload) {
            try {
                $directory = FCPATH . 'uploads/avatars';

                if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
                    throw new \RuntimeException('Avatar directory could not be created.');
                }

                if (! is_writable($directory)) {
                    throw new \RuntimeException('Avatar directory is not writable.');
                }

                // Name and extension come from server-side values, not the client filename.
                $extension = $file->getMimeType() === 'image/png' ? 'png' : 'jpg';
                $newAvatar = bin2hex(random_bytes(16)) . '.' . $extension;
                service('image')->withFile($file->getTempName())
                    ->fit(160, 160, 'center')
                    ->save($directory . '/' . $newAvatar, 85);
                $data['avatar'] = $newAvatar;
            } catch (\Throwable $exception) {
                if ($newAvatar !== null && is_file(FCPATH . 'uploads/avatars/' . $newAvatar)) {
                    unlink(FCPATH . 'uploads/avatars/' . $newAvatar);
                }

                log_message('error', 'Avatar processing failed: {message}', ['message' => $exception->getMessage()]);

                return $this->form('edit', $user, $values, [
                    'avatar' => 'The image could not be prepared. Check the image and upload directory, then try again.',
                ]);
            }
        }

        $model = new UserModel();
        $model->setValidationRule('username', 'required|max_length[50]|' . $unique);

        try {
            $saved = $model->update($id, $data);
        } catch (\Throwable $exception) {
            if ($newAvatar !== null) {
                unlink(FCPATH . 'uploads/avatars/' . $newAvatar);
            }

            throw $exception;
        }

        if ($saved === false) {
            if ($newAvatar !== null) {
                unlink(FCPATH . 'uploads/avatars/' . $newAvatar);
            }

            return $this->form('edit', $user, $values, $model->errors());
        }

        if ((int) session()->get('auth_user_id') === $id) {
            session()->set('auth_username', $data['username']);
        }

        // Delete only files generated by this application, after the new filename is saved.
        $previous = $user['avatar'] ?? null;
        if ($newAvatar !== null && is_string($previous)
            && preg_match('/^[a-f0-9]{32}\.(?:jpg|png)$/D', $previous)
            && is_file(FCPATH . 'uploads/avatars/' . $previous)) {
            unlink(FCPATH . 'uploads/avatars/' . $previous);
        }

        return redirect()->to(site_url('users'))->with('success', 'User updated.');
    }

    private function findOr404(int $id): array
    {
        $user = $id > 0 ? (new UserModel())->find($id) : null;

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        return $user;
    }

    private function postedValues(): array
    {
        $values = [];

        foreach (['username', 'full_name', 'role', 'attendance_status', 'password'] as $field) {
            $input = $this->request->getPost($field);
            $values[$field] = is_string($input)
                ? ($field === 'password' ? $input : trim($input))
                : '';
        }

        $verified = $this->request->getPost('is_verified');
        $values['is_verified'] = $verified === null ? '0' : (is_string($verified) ? $verified : '');

        return $values;
    }

    private function rules(string $unique, bool $creating): array
    {
        return [
            'username'          => 'required|max_length[50]|' . $unique,
            'full_name'         => 'required|max_length[100]',
            'role'              => 'required|in_list[Admin,Store Manager,Cashier,Inventory]',
            'attendance_status' => 'required|in_list[Clocked In,Clocked Out,PTO,AWOL]',
            'is_verified'       => 'required|in_list[0,1]',
            'password'          => ($creating ? 'required' : 'permit_empty') . '|min_length[12]|max_length[72]',
        ];
    }

    private function form(string $mode, ?array $user, array $values, array $errors = []): string
    {
        $data = [
            'title'  => ($mode === 'new' ? 'New User' : 'Edit User') . ' | SwiftPOS',
            'mode'   => $mode,
            'user'   => $user,
            'values' => $values,
            'errors' => $errors,
        ];

        return view('templates/header', $data)
             . view('users/form', $data)
             . view('templates/footer');
    }
}
