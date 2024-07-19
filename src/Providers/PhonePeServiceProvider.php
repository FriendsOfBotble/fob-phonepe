<?php

namespace FriendsOfBotble\PhonePe\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Ecommerce\Models\Currency;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Facades\PaymentMethods;
use FriendsOfBotble\PhonePe\Facades\PhonePePayment;
use FriendsOfBotble\PhonePe\Forms\PhonePePaymentMethodForm;
use FriendsOfBotble\PhonePe\PhonePe\Env;
use FriendsOfBotble\PhonePe\PhonePePaymentClient;
use Illuminate\Http\Request;

class PhonePeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(PhonePePaymentClient::class, function () {
            return new PhonePePaymentClient(
                new \FriendsOfBotble\PhonePe\PhonePe\payments\v1\PhonePePaymentClient(
                    get_payment_setting('merchant_id', PhonePePayment::getId()),
                    get_payment_setting('salt_key', PhonePePayment::getId()),
                    get_payment_setting('salt_index', PhonePePayment::getId()),
                    Env::UAT,
                    true
                )
            );
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/fob-phonepe')
            ->loadAndPublishViews()
            ->publishAssets()
            ->loadAndPublishTranslations()
            ->loadRoutes();

        $this->app->booted(function () {
            add_filter(PAYMENT_METHODS_SETTINGS_PAGE, function (string $html): string {
                return $html . PhonePePaymentMethodForm::create()->renderForm();
            }, 999);

            add_filter(BASE_FILTER_ENUM_ARRAY, function ($values, $class) {
                if ($class === PaymentMethodEnum::class) {
                    $values['PHONEPE'] = PhonePePayment::getId();
                }

                return $values;
            }, 999, 2);

            add_filter(BASE_FILTER_ENUM_LABEL, function ($value, $class) {
                if ($class === PaymentMethodEnum::class && $value == PhonePePayment::getId()) {
                    $value = PhonePePayment::getDisplayName();
                }

                return $value;
            }, 999, 2);

            add_filter(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, function (?string $html, array $data): ?string {
                if (! get_payment_setting('status', PhonePePayment::getId())) {
                    return $html;
                }

                $data = [
                    ...$data,
                    'paymentId' => PhonePePayment::getId(),
                    'paymentDisplayName' => PhonePePayment::getDisplayName(),
                    'supportedCurrencies' => PhonePePayment::supportedCurrencies(),
                ];

                PaymentMethods::method(PhonePePayment::getId(), [
                    'html' => view('plugins/fob-phonepe::payment-method', $data)->render(),
                ]);

                return $html;
            }, 999, 2);
        });

        add_filter(PAYMENT_FILTER_AFTER_POST_CHECKOUT, function (array $data, Request $request) {
            if ($data['type'] !== PhonePePayment::getId()) {
                return $data;
            }

            $currentCurrency = get_application_currency();

            $data = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);

            if (! in_array(strtoupper($currentCurrency->title), PhonePePayment::supportedCurrencies())) {
                $supportedCurrency = Currency::query()
                    ->whereIn('title', PhonePePayment::supportedCurrencies())
                    ->first();

                if ($supportedCurrency) {
                    $data['currency'] = strtoupper($supportedCurrency->title);
                    if ($currentCurrency->is_default) {
                        $data['amount'] = $data['amount'] * $supportedCurrency->exchange_rate;
                    } else {
                        $data['amount'] = format_price(
                            $data['amount'] / $currentCurrency->exchange_rate,
                            $currentCurrency,
                            true
                        );
                    }
                }
            }

            $result = PhonePePayment::authorize($data, $request);

            return [...$data, ...$result];
        }, 999, 2);
    }
}
