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
            <div>Subscrition</div>
            <div>
                <a href="{{ auth()->user()->billingPortalUrl(route('account.subscriptions')) }}">Billing portal</a>
            </div>
        </x-slot>
    </x-account>
</x-app-layout>
