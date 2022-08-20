<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <x-account>
        <x-slot name="account">
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upadate card') }}
            </div>

            <x-card-form :action="route('account.subscriptions.card')">
                <x-button id="card-button" data-secret="{{ $intent->client_secret }}"> {{ __('Upadate') }} </x-button>
            </x-card-form>
        </x-slot>
    </x-account>
</x-app-layout>
