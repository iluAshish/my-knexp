<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    protected Customer $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $customer = $this->model->find($id);

        if ($customer) {
            $customer->update($data);
            return $customer;
        }

        return null;
    }

    public function delete($id)
    {
        $customer = $this->model->find($id);

        if ($customer) {
            $customer->delete();
            return true;
        }

        return false;
    }

    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->model->firstOrCreate($attributes, $values);
    }
}
