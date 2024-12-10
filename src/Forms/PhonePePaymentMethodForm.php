<?php

namespace FriendsOfBotble\PhonePe\Forms;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\RadioFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\RadioField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Payment\Forms\PaymentMethodForm;
use FriendsOfBotble\PhonePe\Facades\PhonePePayment;

class PhonePePaymentMethodForm extends PaymentMethodForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->paymentId(PhonePePayment::getId())
            ->paymentName(PhonePePayment::getDisplayName())
            ->paymentDescription(__('Customer can buy product and pay directly using Visa, Credit card via :name', ['name' => 'PhonePe']))
            ->paymentLogo(url('vendor/core/plugins/fob-phonepe/images/phonepe.png'))
            ->paymentUrl('https://www.phonepe.com')
            ->paymentInstructions(view('plugins/fob-phonepe::instructions')->render())
            ->add(
                get_payment_setting_key('merchant_id', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/fob-phonepe::phonepe.merchant_id'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('merchant_id', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('salt_key', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/fob-phonepe::phonepe.salt_key'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('salt_key', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('salt_index', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/fob-phonepe::phonepe.salt_index'))
                    ->value(get_payment_setting('salt_index', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('environment', PhonePePayment::getId()),
                RadioField::class,
                RadioFieldOption::make()
                    ->label(trans('plugins/fob-phonepe::phonepe.environment'))
                    ->choices([
                        'PRODUCTION' => trans('plugins/fob-phonepe::phonepe.production'),
                        'UAT' => trans('plugins/fob-phonepe::phonepe.testing'),
                    ])
                    ->selected(get_payment_setting('environment', PhonePePayment::getId(), 'UAT'))
            )
            ->add(
                get_payment_setting_key('should_public_events', PhonePePayment::getId()),
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/fob-phonepe::phonepe.should_public_events'))
                    ->value(get_payment_setting('should_public_events', PhonePePayment::getId(), false))
            );
    }
}
