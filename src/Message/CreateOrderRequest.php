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
}
