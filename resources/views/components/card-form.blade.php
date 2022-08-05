<form action="{{ $action }}" method="post" id="card-form">
    @csrf

    <div>
        <label class="mb-2">Name on card</label>
        <x-input type="text" name="email" id="card-holder-name" class="block w-full mb-4"  />
    </div>
    <div class="mb-4">
        <label class="mb-2">Card details</label>
        <div id="card-element"></div>
    </div>

    {{ $slot }}
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
