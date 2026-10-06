<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Customers extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();

        $data = [
            'title'     => 'Customer Accounts | SwiftPOS',
            'customers' => $customerModel
                ->select(['id', 'full_name', 'email', 'phone', 'status'])
                ->orderBy('id', 'ASC')
                ->findAll(),
        ];

        return view('templates/header', $data)
             . view('customers/index', $data)
             . view('templates/footer');
    }

    public function newForm(): string
    {
        return $this->form('new', null, [
            'full_name' => '', 'email' => '', 'phone' => '', 'status' => 'Active',
        ]);
    }

    public function create(): string|RedirectResponse
    {
        $values = $this->postedValues();
        $rules  = $this->rules('is_unique[customers.email]', true);

        if (! $this->validateData($values, $rules)) {
            return $this->form('new', null, $values, $this->validator->getErrors());
        }

        $valid = $this->validator->getValidated();
        $model = new CustomerModel();
        // The model also validates. Use an explicit uniqueness rule for this operation.
        $model->setValidationRule('email', 'required|valid_email|max_length[100]|is_unique[customers.email]');

        if ($model->insert([
            'full_name'     => $valid['full_name'],
            'email'         => $valid['email'],
            'phone'         => $valid['phone'] === '' ? null : $valid['phone'],
            'status'        => $valid['status'],
            'password_hash' => password_hash($valid['password'], PASSWORD_DEFAULT),
        ]) === false) {
            return $this->form('new', null, $values, $model->errors());
        }

        return redirect()->to(site_url('customers'))->with('success', 'Customer created.');
    }

    public function edit(int $id): string
    {
        $customer = $this->findOr404($id);

        return $this->form('edit', $customer, [
            'full_name' => $customer['full_name'],
            'email'     => $customer['email'],
            'phone'     => $customer['phone'] ?? '',
            'status'    => $customer['status'],
        ]);
    }

    public function update(int $id): string|RedirectResponse
    {
        $customer = $this->findOr404($id);
        $values   = $this->postedValues();
        // The ignored ID comes from the numeric URL and an existing database row.
        $unique = 'is_unique[customers.email,id,' . $id . ']';

        if (! $this->validateData($values, $this->rules($unique, false))) {
            return $this->form('edit', $customer, $values, $this->validator->getErrors());
        }

        $valid = $this->validator->getValidated();
        $data  = [
            'full_name' => $valid['full_name'],
            'email'     => $valid['email'],
            'phone'     => $valid['phone'] === '' ? null : $valid['phone'],
            'status'    => $valid['status'],
        ];

        if ($valid['password'] !== '') {
            $data['password_hash'] = password_hash($valid['password'], PASSWORD_DEFAULT);
        }

        $model = new CustomerModel();
        $model->setValidationRule('email', 'required|valid_email|max_length[100]|' . $unique);

        if ($model->update($id, $data) === false) {
            return $this->form('edit', $customer, $values, $model->errors());
        }

        return redirect()->to(site_url('customers'))->with('success', 'Customer updated.');
    }

    private function findOr404(int $id): array
    {
        $customer = $id > 0 ? (new CustomerModel())->find($id) : null;

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return $customer;
    }

    private function postedValues(): array
    {
        $values = [];

        foreach (['full_name', 'email', 'phone', 'status', 'password'] as $field) {
            $input = $this->request->getPost($field);
            $values[$field] = is_string($input)
                ? ($field === 'password' ? $input : trim($input))
                : '';
        }

        return $values;
    }

    private function rules(string $unique, bool $creating): array
    {
        return [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]|' . $unique,
            'phone'     => 'permit_empty|max_length[25]',
            'status'    => 'required|in_list[Active,Inactive]',
            'password'  => ($creating ? 'required' : 'permit_empty') . '|min_length[8]|max_length[72]',
        ];
    }

    private function form(string $mode, ?array $customer, array $values, array $errors = []): string
    {
        $data = [
            'title'    => ($mode === 'new' ? 'New Customer' : 'Edit Customer') . ' | SwiftPOS',
            'mode'     => $mode,
            'customer' => $customer,
            'values'   => $values,
            'errors'   => $errors,
        ];

        return view('templates/header', $data)
             . view('customers/form', $data)
             . view('templates/footer');
    }
}
