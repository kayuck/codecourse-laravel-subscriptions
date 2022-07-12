<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <x-account>
        <x-slot name="account">
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoices') }}
            </div>
            @foreach ( $invoices as $invoice )
                <div>
                    {{ $invoice->date()->toFormattedDateString() }}
                    {{ $invoice->total() }}
                    <a href="{{ route('account.subscriptions.invoice', $invoice->id) }}">Download</a>
                </div>
            @endforeach
        </x-slot>
    </x-account>
</x-app-layout>
