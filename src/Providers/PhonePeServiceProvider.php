<?php

namespace FriendsOfBotble\PhonePe\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Ecommerce\Models\Currency;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Facades\PaymentMethods;
use Botble\Payment\Models\Payment;
use FriendsOfBotble\PhonePe\Contracts\PhonePePayment as PhonePePaymentContract;
use FriendsOfBotble\PhonePe\Facades\PhonePePayment as PhonePePaymentFacade;
use FriendsOfBotble\PhonePe\Forms\PhonePePaymentMethodForm;
use FriendsOfBotble\PhonePe\PhonePePayment;
use FriendsOfBotble\PhonePe\PhonePePaymentClient;
use Illuminate\Http\Request;

class PhonePeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        if (! is_plugin_active('payment')) {
            return;
        }

        $this->app->bind(PhonePePaymentClient::class, function () {
            return new PhonePePaymentClient(
                new \FriendsOfBotble\PhonePe\PhonePe\payments\v1\PhonePePaymentClient(
                    get_payment_setting('merchant_id', PhonePePaymentFacade::getId()),
                    get_payment_setting('salt_key', PhonePePaymentFacade::getId()),
                    get_payment_setting('salt_index', PhonePePaymentFacade::getId()),
                    get_payment_setting('environment', PhonePePaymentFacade::getId(), 'UAT'),
                    get_payment_setting('should_public_events', PhonePePaymentFacade::getId(), false)
                )
            );
        });

        $this->app->bind(PhonePePaymentContract::class, fn () => new PhonePePayment());
    }

    public function boot(): void
    {
        if (! is_plugin_active('payment')) {
            return;
        }

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
                    $values['PHONEPE'] = PhonePePaymentFacade::getId();
                }

                return $values;
            }, 999, 2);

            add_filter(BASE_FILTER_ENUM_LABEL, function ($value, $class) {
                if ($class === PaymentMethodEnum::class && $value == PhonePePaymentFacade::getId()) {
                    $value = PhonePePaymentFacade::getDisplayName();
                }

                return $value;
            }, 999, 2);

            add_filter(PAYMENT_FILTER_GET_SERVICE_CLASS, function (string $class, string $payment) {
                if ($payment == PhonePePaymentFacade::getId()) {
                    $class = PhonePePayment::class;
                }

                return $class;
            }, 999, 2);

            add_filter(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, function (?string $html, array $data): ?string {
                if (! get_payment_setting('status', PhonePePaymentFacade::getId())) {
                    return $html;
                }

                $data = [
                    ...$data,
                    'paymentId' => PhonePePaymentFacade::getId(),
                    'paymentDisplayName' => PhonePePaymentFacade::getDisplayName(),
                    'supportedCurrencies' => PhonePePaymentFacade::supportedCurrencies(),
                ];

                PaymentMethods::method(PhonePePaymentFacade::getId(), [
                    'html' => view('plugins/fob-phonepe::payment-method', $data)->render(),
                ]);

                return $html;
            }, 999, 2);
        });

        add_filter(PAYMENT_FILTER_AFTER_POST_CHECKOUT, function (array $data, Request $request) {
            if ($data['type'] !== PhonePePaymentFacade::getId()) {
                return $data;
            }

            $currentCurrency = get_application_currency();

            $data = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);

            if (! in_array(strtoupper($currentCurrency->title), PhonePePaymentFacade::supportedCurrencies())) {
                $supportedCurrency = Currency::query()
                    ->whereIn('title', PhonePePaymentFacade::supportedCurrencies())
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
                        ) * $supportedCurrency->exchange_rate;
                    }
                }
            }

            $result = PhonePePaymentFacade::authorize($data, $request);

            return [...$data, ...$result];
        }, 999, 2);

        add_filter(PAYMENT_FILTER_PAYMENT_INFO_DETAIL, function (?string $html, Payment $payment): ?string {
            if ($payment->payment_channel == PhonePePaymentFacade::getId()) {
                $response = $this->app->make(PhonePePaymentClient::class)->getStatus($payment->charge_id);

                $html = view('plugins/fob-phonepe::detail', compact('response'))->render();
            }

            return $html;
        }, 999, 2);
    }
}
