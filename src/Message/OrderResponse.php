<?php

namespace Omnipay\Encoded\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class OrderResponse extends Response
{
    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    public function getTransactionReference()
    {
        if (isset($this->data['ref'])) {
            return $this->data['ref'];
        }
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getDescription()
    {
        return $this->data['description'];
    }
}
