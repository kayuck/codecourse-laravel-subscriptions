<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <x-account>
        <x-slot name="account">
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cancel') }}
            </div>
            <form action="{{ route('account.subscriptions.cancel') }}" method="post">
                @csrf

                <x-button> {{ __('Cancel') }} </x-button>
            </form>
        </x-slot>
    </x-account>
</x-app-layout>
