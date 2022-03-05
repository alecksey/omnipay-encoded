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
}
