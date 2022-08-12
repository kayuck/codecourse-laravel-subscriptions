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
                @if ($subscription)
                    <ul>
                        <li>
                            Plan: {{ auth()->user()->userPlan()->title }} ( {{ money($subscription->amount()) }} / {{ $subscription->interval() }} )
                            @if (auth()->user()->subscription('default')->cancelled())
                                Ends {{ $subscription->cancelAt() }}. <a href="{{ route('account.subscriptions.resume') }}">Resume</a>
                            @endif
                        </li>
                    </ul>
                @endif
            @else
                <p>You don't have a subscription</p>
            @endif

            <div>
                <a href="{{ auth()->user()->billingPortalUrl(route('account.subscriptions')) }}">Billing portal</a>
            </div>
        </x-slot>
    </x-account>
</x-app-layout>
