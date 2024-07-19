<x-plugins-payment::payment-method
    :$selecting
    :name="$paymentId"
    :paymentName="$paymentDisplayName"
    :supportedCurrencies="$supportedCurrencies"
/>
