<?php

namespace App\Presenters;

use Carbon\Carbon;

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
