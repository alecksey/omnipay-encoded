<?php

namespace Omnipay\Encoded\Message\Customer;

class CreateCustomerRequest extends \Omnipay\Encoded\Message\AbstractRequest
{
    protected $api_suffix = '/customers';

    protected $method = 'POST';

    public function getData()
    {

        $this->validate('forename', 'surname', 'transactionReference');

        $country = $this->getAddressCountry();

        if (null !== $country) {

            try {
                if (mb_strlen($country, 'UTF-8') === 2) {
                    $country_data = (new \League\ISO3166\ISO3166)->alpha2($country);
                } else {
                    $country_data = (new \League\ISO3166\ISO3166)->alpha3($country);
                }

                $country = $country_data['alpha3'];

            } catch (\Exception $e) {
                throw new \Omnipay\Common\Exception\InvalidRequestException(
                    'Invalid country code, please use Alpha-3 code'
                );
            }

        }

        $data = [
            'object' => 'customer',
            'ref' => $this->getTransactionReference(),
            'forename' => $this->getForename(),
            'surname' => $this->getSurname(),
            'contact' => [
                'object' => 'contact',
                'address' => [
                    'object' => 'address',
                    'forename' => $this->getForename(),
                    'surname' => $this->getSurname(),
                    'country' => $country,
                    'postcode' => $this->getAddressPostCode(),
                    'address' => $this->getAddress(),
                    'street' => 'srewr',
                    'address1' => '23423432',

                ],
                'email' => $this->getEmail(),
                'attributes' => [
                    'account' => [
                        'address' => 'address'
                    ]
                ]
            ]
        ];

        return [
            $data
        ];
    }


    public function setForename($forename)
    {
        $this->setParameter('forename', $forename);

        return $this;
    }

    public function setSurname($surname)
    {
        $this->setParameter('surname', $surname);

        return $this;
    }

    public function setEmail($email)
    {
        $this->setParameter('email', $email);

        return $this;
    }

    public function setAddressCountry($country)
    {
        $this->setParameter('address_country', $country);

        return $this;
    }

    public function setAddressPostCode($postcode)
    {
        $this->setParameter('address_postcode', $postcode);

        return $this;
    }

    public function getForename()
    {
        return $this->getParameter('forename');
    }

    public function getSurname()
    {
        return $this->getParameter('surname');
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function getAddressCountry()
    {
        return $this->getParameter('address_country');
    }

    public function getAddressPostCode()
    {
        return $this->getParameter('address_postcode');
    }

    public function setAddress($address)
    {
        $this->setParameter('address', $address);

        return $this;
    }

    public function getAddress()
    {
        return $this->getParameter('address');
    }

    protected function createResponse($data)
    {
        if (!isset($data[0])) {
            throw new \Omnipay\Common\Exception\InvalidResponseException('Invalid response from gateway');
        }

        return $this->response = new CustomerResponse($this, $data[0]);
    }
}
