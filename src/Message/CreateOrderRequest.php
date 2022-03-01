<?php

namespace Omnipay\Encoded\Message;

class CreateOrderRequest extends AbstractRequest
{
    protected $api_suffix = '/orders';

    protected $method = 'POST';


    public function getData()
    {
        $this->validate('currency', 'amount', 'transactionReference', 'returnUrl');


        return [
            [
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
            ]
        ];
    }

    protected function createResponse($data)
    {
        if(!isset($data[0])) {
            throw new \Omnipay\Common\Exception\InvalidResponseException('Invalid response from gateway');
        }

        return $this->response = new OrderResponse($this, $data[0]);
    }
}
