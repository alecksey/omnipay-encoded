<?php

namespace Omnipay\Encoded\Message;

class GetTransactionRequest extends AbstractRequest
{
    protected $method = 'GET';


    public function getData()
    {
        $this->validate('transactionId');

        return [
            'id' => $this->getTransactionId()
        ];
    }
}
