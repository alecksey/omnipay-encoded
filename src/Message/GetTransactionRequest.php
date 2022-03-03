<?php

namespace Omnipay\Encoded\Message;

class GetTransactionRequest extends AbstractRequest
{
    protected $method = 'GET';

    protected $api_suffix = '/transactions';

    protected $query_type = self::GET_QUERY_TYPE_SINGE;

    public function getData()
    {
        $this->validate('transactionId');

        return [
            'id' => $this->getTransactionId()
        ];
    }

    public function createResponse($data) {
        if(!isset($data[0])) {
            throw new \Omnipay\Common\Exception\InvalidResponseException('Invalid response from gateway');
        }
    }
}
