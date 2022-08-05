<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <x-account>
        <x-slot name="account">
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Coupon') }}
            </div>
            <form action="{{ route('account.subscriptions.coupon') }}" method="post">
                @csrf

                <div>
                    <label class="mb-2">Coupon</label>
                    <x-input type="text" name="coupon" id="coupon" class="block w-full mb-4" />
                </div>
                <x-button> {{ __('Apply') }} </x-button>
            </form>
        </x-slot>
    </x-account>
</x-app-layout>
