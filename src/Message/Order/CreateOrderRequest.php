<?php

namespace Omnipay\Encoded\Message\Order;

class CreateOrderRequest extends \Omnipay\Encoded\Message\AbstractRequest
{
    protected $api_suffix = '/orders';

    protected $method = 'POST';


    public function getData()
    {
        $this->validate('currency', 'amount', 'transactionReference', 'returnUrl');


        $contact = null;

        if (!empty($this->getContactForename()) && !empty($this->getContactSurname())) {
            $contact = [
                'object' => 'customer',
                'ref' => 'CUSTOMER-1',
                'forename' => $this->getContactForename(),
                'surname' => $this->getContactSurname(),
                'contact' => [
                    'object' => 'contact',
                    'address' => [
                        'object' => 'address',
                        'forename' => $this->getContactForename(),
                        'surname' => $this->getContactSurname(),
                        'postcode' => $this->getContactAddressPostCode(),
                        'country' => $this->getContactAddressCountry()
                    ],
                    'email' => $this->getContactEmail()
                ]
            ];
        }

        $data = [
            'object' => 'order',
            'ref' => $this->getTransactionReference(),
            'currency' => $this->getCurrency(),
            'totalAmount' => $this->getAmount(),
            'hpp' => [
                'returnUrl' => $this->getReturnUrl(),
                'tokens' => [
                    'enabled' => false
                ]
            ]
        ];

        $hppView = [];
        $hppViewOrder = [];
        $hppViewPayment = [];

        if (null !== $this->getHppViewTheme()) {
            $hppView['theme'] = $this->getHppViewTheme();
        }

        if (null !== $this->getHppViewOrderType()) {
            $hppView['type'] = $this->getHppViewOrderType();
        }

        if (null !== $this->getHppViewOrderDisplayPayee() ||
            null !== $this->getHppViewOrderDisplayItems() ||
            null !== $this->getHppViewOrderDisplayTotalAmount()) {
            $hppViewOrder = [
                'display' => []
            ];

            if (null !== $this->getHppViewOrderDisplayPayee()) {
                $hppViewOrder['display']['payee'] = $this->getHppViewOrderDisplayPayee();
            }

            if (null !== $this->getHppViewOrderDisplayItems()) {
                $hppViewOrder['display']['items'] = $this->getHppViewOrderDisplayItems();
            }

            if (null !== $this->getHppViewOrderDisplayTotalAmount()) {
                $hppViewOrder['display']['totalAmount'] = $this->getHppViewOrderDisplayTotalAmount();
            }
        }

        if (count($hppViewOrder) > 0) {
            $hppView['order'] = $hppViewOrder;
        }

        if (null !== $this->getHppViewPaymentApplePayEnabled()) {
            $hppViewPayment['applePay'] = [
                'enabled' => $this->getHppViewPaymentApplePayEnabled()
            ];
        }

        if (null !== $this->getHppViewPaymentGooglePayEnabled()) {
            $hppViewPayment['googlePay'] = [
                'enabled' => $this->getHppViewPaymentGooglePayEnabled()
            ];
        }

        if (count($hppViewPayment) > 0) {
            $hppView['payment'] = $hppViewPayment;
        }

        if (count($hppView) > 0) {
            $data['hpp']['view'] = $hppView;
        }

        if (null !== $contact) {
            $data['billingCustomer'] = $contact;
        }

        return [
            $data
        ];
    }

    protected function createResponse($data)
    {
        if (!isset($data[0])) {
            throw new \Omnipay\Common\Exception\InvalidResponseException('Invalid response from gateway');
        }

        return $this->response = new OrderResponse($this, $data[0]);
    }

    public function setContactForename($forename)
    {
        $this->setParameter('contact_forename', $forename);

        return $this;
    }

    public function setContactSurname($surname)
    {
        $this->setParameter('contact_surname', $surname);

        return $this;
    }

    public function setContactEmail($email)
    {
        $this->setParameter('contact_email', $email);
    }

    public function setContactAddressCountry($country)
    {
        $this->setParameter('contact_address_country', $country);

        return $this;
    }

    public function setContactAddressAddress($address)
    {
        $this->setParameter('contact_address_address', $address);

        return $this;
    }

    public function setContactAddressCity($city)
    {
        $this->setParameter('contact_address_city', $city);

        return $this;
    }

    public function setContactAddressState($state)
    {
        $this->setParameter('contact_address_state', $state);

        return $this;
    }

    public function setContactAddressPostCode($post_code)
    {
        $this->setParameter('contact_address_postcode', $post_code);

        return $this;
    }

    public function getContactForename()
    {
        return $this->getParameter('contact_forename');
    }

    public function getContactSurname()
    {
        return $this->getParameter('contact_surname');
    }

    public function getContactEmail()
    {
        return $this->getParameter('contact_email');
    }

    public function getContactAddressCountry()
    {
        return $this->getParameter('contact_address_country');
    }

    public function getContactAddressAddress()
    {
        return $this->getParameter('contact_address_address');
    }

    public function getContactAddressCity()
    {
        return $this->getParameter('contact_address_city');
    }

    public function getContactAddressState()
    {
        return $this->getParameter('contact_address_state');
    }

    public function getContactAddressPostCode()
    {
        return $this->getParameter('contact_address_postcode');
    }

    public function getHppViewTheme()
    {
        return $this->getParameter('hpp_view_theme');
    }

    /**
     * @param string $theme classic or modern
     * @return $this
     */
    public function setHppViewTheme(string $theme)
    {
        if (!in_array($theme, ['classic', 'modern'])) {
            throw new \Omnipay\Encoded\Exception\InvalidValueException($theme, '[classic, modern]');
        }

        $this->setParameter('hpp_view_theme', $theme);

        return $this;
    }

    public function getHppViewOrderType()
    {
        return $this->getParameter('hpp_view_order_type');
    }

    /**
     * @param string $type minimum or expanded
     * @return void
     */
    public function setHppViewOrderType(string $type)
    {
        //minimum, expanded
        if (!in_array($type, ['minimum', 'expanded'])) {
            throw new \Omnipay\Encoded\Exception\InvalidValueException($type, '[minimum, expanded]');
        }
        $this->setParameter('hpp_view_order_type', $type);
    }

    public function getHppViewOrderDisplayPayee()
    {
        return $this->getParameter('hpp_view_order_display_payee');
    }

    public function setHppViewOrderDisplayPayee(bool $flag)
    {
        $this->setParameter('hpp_view_order_display_payee', $flag);

        return $this;
    }

    public function getHppViewOrderDisplayItems()
    {
        return $this->getParameter('hpp_view_order_display_items');
    }

    public function setHppViewOrderDisplayItems(bool $flag)
    {
        $this->setParameter('hpp_view_order_display_items', $flag);

        return $this;
    }

    public function getHppViewOrderDisplayTotalAmount()
    {
        return $this->getParameter('hpp_view_order_display_total_amount');
    }

    public function setHppViewOrderDisplayTotalAmount(bool $flag)
    {
        $this->setParameter('hpp_view_order_display_total_amount', $flag);

        return $this;
    }

    public function getHppViewPaymentApplePayEnabled()
    {
        return $this->getParameter('hpp_view_payment_apple_pay_enabled');
    }

    public function setHppViewPaymentApplePayEnabled(bool $flag)
    {
        $this->setParameter('hpp_view_payment_apple_pay_enabled', $flag);

        return $this;
    }

    public function getHppViewPaymentGooglePayEnabled()
    {
        return $this->getParameter('hpp_view_payment_google_pay_enabled');
    }

    public function setHppViewPaymentGooglePayEnabled(bool $flag)
    {
        $this->setParameter('hpp_view_payment_google_pay_enabled', $flag);

        return $this;
    }
}
