<?php

namespace Omnipay\Encoded\Message\Transaction;

class TransactionResponse extends \Omnipay\Encoded\Message\Response
{
    protected $result_response = null;

    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    /**
     * @return TransactionResponseResponse
     */
    public function getResultResponse()
    {
        if (null === $this->result_response) {
            $this->result_response = new TransactionResponseResponse($this->request, $this->data['response']);
        }

        return $this->result_response;
    }
}
