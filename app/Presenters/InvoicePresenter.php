<?php

namespace App\Presenters;

use Carbon\Carbon;

class InvoicePresenter
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function nextPaymentAttempt()
    {
        return (new Carbon($this->model->next_payment_attempt))->isoFormat('Y/M/D(ddd)');
    }

    public function amount()
    {
        return $this->model->amount_due;
    }

}
