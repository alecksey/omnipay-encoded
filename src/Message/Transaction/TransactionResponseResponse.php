<?php

namespace Omnipay\Encoded\Message\Transaction;

class TransactionResponseResponse extends \Omnipay\Encoded\Message\Response
{
    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    public function getResultType()
    {
        return $this->data['result']['resultType'];
    }

    public function getResultCode()
    {
        return $this->data['result']['resultCode'];
    }

    public function getResultMessage()
    {
        return $this->data['result']['message'];
    }
}
