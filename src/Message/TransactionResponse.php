<?php

namespace Omnipay\Encoded\Message;

class TransactionResponse extends Response
{
    protected $result_response = null;

    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    /**
     * @return TransactionResponseResponse
     */
    public function getResponse()
    {
        if(null === $this->result_response) {
            $this->result_response = new TransactionResponseResponse($this->request, $this->data['response']);
        }

        return $this->result_response;
    }
}
