<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-card-form :action="route('subscriptions.store')">
                        <input type="hidden" name="plan" value="{{ request('plan') }}">
                        <div>
                            <label class="mb-2">Coupon</label>
                            <x-input type="text" name="coupon" id="coupon" class="block w-full mb-4" />
                        </div>

                        <x-button id="card-button" data-secret="{{ $intent->client_secret }}"> {{ __('pay') }} </x-button>
                    </x-card-form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
