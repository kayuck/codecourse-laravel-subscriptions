<div class="mx-auto sm:px-6 lg:px-8 max-w-7xl py-12 grid grid-cols-6 gap-4">
    <div class="col-span-1">
        <ul class="mb-4">
            <li class="text-indigo-500"><a href="{{ route('account') }}">Account</a></li>
        </ul>
        <ul class="mb-4">
            <li class="text-indigo-500"><a href="{{ route('account.subscriptions') }}">Subscription</a></li>
            @if (auth()->user()->subscribed())
                @can('cancel',
                    auth()->user()->subscription('default'),)
                    <li class="text-indigo-500"><a href="{{ route('account.subscriptions.cancel') }}">Cancel subscription</a></li>
                @endcan

                @can('resume',
                    auth()->user()->subscription('default'),)
                    <li class="text-indigo-500"><a href="{{ route('account.subscriptions.resume') }}">Resume subscription</a></li>
                @endcan
            @endif

            <li class="text-indigo-500"><a href="{{ route('account.subscriptions.invoices') }}">Invoices</a></li>
        </ul>
    </div>

    <div class="col-span-5 sm:px-6 lg:px8">
        {{ $account }}
    </div>

</div>
