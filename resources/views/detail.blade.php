@php
    /** @var $response \FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgCheckStatusResponse */
@endphp

<x-core::form.fieldset class="mt-3">
    <x-core::datagrid>
        @if($response->getTransactionId())
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/fob-phonepe::phonepe.transaction_id') }}</x-slot:title>
                {{ $response->getTransactionId() }}
            </x-core::datagrid.item>
        @endif
        @if($response->getAmount())
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/fob-phonepe::phonepe.amount') }}</x-slot:title>
                {{ format_price($response->getAmount(), 'INR') }}
            </x-core::datagrid.item>
        @endif
        @if($response->getState())
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/fob-phonepe::phonepe.state') }}</x-slot:title>
                {{ $response->getState() }}
            </x-core::datagrid.item>
        @endif
    </x-core::datagrid>

    <div class="mt-3">
        <label class="form-label">
            {{ trans('plugins/fob-phonepe::phonepe.response') }}
        </label>
        <pre>{{ json_encode($response->jsonSerialize(), JSON_PRETTY_PRINT) }}</pre>
    </div>
</x-core::form.fieldset>
