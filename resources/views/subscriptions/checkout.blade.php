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
                    <form action="{{ route('subscriptions.store') }}" method="post" id="card-form">
                        @csrf
                        <input type="hidden" name="plan" value="{{ request('plan') }}">
                        <div class="form-group">
                            <label for="card-holder-name">Name on card</label>
                            <input type="text" name="name" id="card-holder-name" class="from-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Card details</label>
                            <div id="card-element"></div>
                        </div>

                        <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}">pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const stripe = Stripe('{{ config('cashier.key') }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const form = document.getElementById('card-form');
        const cardButton = document.getElementById('card-button');
        const cardHolderName = document.getElementById('card-holder-name');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            cardButton.disabled = true;

            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                cardButton.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                cardButton.disabled = false;
            } else {
                let token = document.createElement('input');
                token.setAttribute('type', 'hidden');
                token.setAttribute('name', 'token');
                token.setAttribute('value', setupIntent.payment_method);

                form.appendChild(token);

                form.submit();
            }
        });
    </script>
</x-app-layout>
