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
            <form action="{{ route('account.subscriptions.card') }}" method="post" id="card-form">
                @csrf

                <div class="form-group">
                    <label for="card-holder-name">Name on card</label>
                    <input type="text" name="name" id="card-holder-name" class="from-control">
                </div>
                <div class="form-group">
                    <label for="name">Card details</label>
                    <div id="card-element"></div>
                </div>

                <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}">Upadate</button>

                <x-button> {{ __('Upadate') }} </x-button>
            </form>

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
        </x-slot>
    </x-account>
</x-app-layout>
