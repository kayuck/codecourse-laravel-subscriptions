<?php

namespace App\Http\Controllers\Account\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionSwapController extends Controller
{
    public function index(Request $request)
    {

        /*
        15. Swapping plans 参照。このやり方だとうまくいかないので、下記 userPlan() を使う。
        $plans = Plan::where('slug', '!=', $request->user()->plan->slug)->get();
        */
        $otherPlans = Plan::where('slug', '!=', $request->user()->userPlan()->slug)->get();
        return view('account.subscriptions.swap', compact('otherPlans'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'plan' => 'required|exists:plans,slug'
            ]
        );

        try {
            $request->user()->subscription('default')
                ->swap(Plan::where('slug', $request->plan)->first()->stripe_id);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [
                    $exception->payment->id,
                    'redirect' => route('account.subscriptions')
                ]
            );
        }


        return redirect()->route('account.subscriptions');
    }
}
