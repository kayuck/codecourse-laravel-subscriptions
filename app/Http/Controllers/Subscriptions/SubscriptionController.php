<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Rules\ValidCoupon;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        return view('subscriptions.checkout', [
            'intent' => $request->user()->createSetupIntent()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'token' => 'required',
                'coupon' => [
                    'nullable',
                    new ValidCoupon()
                ],
                'plan' => 'required|exists:plans,slug'
            ]
        );

        $plan = Plan::where('slug', $request->get('plan', 'monthly'))
            ->first();

        try {
            $request->user()->newSubscription('default', $plan->stripe_id)
                ->withCoupon($request->coupon)
                ->create($request->token);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',[
                    $exception->payment->id,
                    'redirect'=> route('account.subscriptions')
                ]
            );
        }


        return back();
    }
}
