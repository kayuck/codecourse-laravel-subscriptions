<?php

namespace App\Presenters;

use Carbon\Carbon;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class SubscriptionPresenter
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function cancelAt()
    {
        dd($this->model->plan->created, (new Carbon($this->model->plan->cancel_at))->isoFormat('Y/M/D(ddd)'));
        return (new Carbon($this->model->plan->cancel_at))->isoFormat('Y/M/D(ddd)');
    }

    /*
    29.参照
    public function amount(){
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter(config('cashier.currency_locale'), NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        $money = new Money(
            $this->model->plan->amount,
            new Currency(strtoupper(config('cashier.currency')))
        );

        return $formatter->format($money);
    }
    */
    public function amount()
    {
        return $this->model->plan->amount;
    }

    public function interval()
    {
        return $this->model->plan->interval;
    }
}
