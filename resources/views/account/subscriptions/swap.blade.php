<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <x-account>
        <x-slot name="account">
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Swap') }}
            </div>
            <form action="{{ route('account.subscriptions.swap') }}" method="post">
                @csrf

                <x-select class="w-full mb-4" name="plan">
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->slug }}">{{ $plan->title }}</option>
                    @endforeach
                </x-select>

                <x-button> {{ __('Swap') }} </x-button>
            </form>
        </x-slot>
    </x-account>
</x-app-layout>
