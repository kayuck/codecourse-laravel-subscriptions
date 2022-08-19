<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscrition') }}
        </h2>
    </x-slot>

    <x-account>
        <x-slot name="account">
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Subscrition') }}
            </div>
            @if (auth()->user()->subscribed())
                <ul>
                    @if ($subscription)
                        <li>
                            Plan: {{ auth()->user()->userPlan()->title }} ( @money($subscription->amount()) / {{ $subscription->interval() }} )
                            @if (auth()->user()->subscription('default')->cancelled())
                                Ends {{ $subscription->cancelAt() }}. <a href="{{ route('account.subscriptions.resume') }}" class="text-indigo-500">Resume</a>
                            @endif
                        </li>
                    @endif

                    @if ($coupon = $subscription->coupon())
                        <li>
                            Coupon: {{ $coupon->name() }} ( {{ $coupon->value() }} off )
                        </li>
                    @endif

                    @if ($invoice)
                        <li>
                            Next payment: @money($invoice->amount()) on {{ $invoice->nextPaymentAttempt() }}
                        </li>
                    @endif

                    @if ($customer)
                        <li>
                            Balance: {{ $customer->balance() }}
                        </li>
                    @endif
                </ul>
            @else
                <p>You don't have a subscription</p>
            @endif

            <div>
                <a href="{{ auth()->user()->billingPortalUrl(route('account.subscriptions')) }}" class="text-indigo-500">Billing portal</a>
            </div>
        </x-slot>
    </x-account>
</x-app-layout>
