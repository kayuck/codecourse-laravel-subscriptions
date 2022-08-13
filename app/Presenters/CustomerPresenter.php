<?php

namespace App\Presenters;

class CustomerPresenter
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function balance()
    {
        return $this->model->balance;
    }

}
