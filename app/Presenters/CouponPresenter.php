<?php

namespace App\Presenters;

use Cknow\Money\Money;

class CouponPresenter
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function name()
    {
        return $this->model->name;
    }

    private function percent()
    {
        return $this->model->percent_off . '%';
    }

    private function amount()
    {
        return Money::JPY($this->model->amount_off);
    }

    public function value()
    {
        return $this->model->amount_off ? $this->amount() : $this->percent();
    }

}
