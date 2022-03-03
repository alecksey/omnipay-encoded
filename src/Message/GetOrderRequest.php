<?php

namespace Omnipay\Encoded\Message;

class GetOrderRequest extends AbstractRequest
{
    protected $method = 'GET';

    protected $api_suffix = '/orders';

    protected $query_type = self::GET_QUERY_TYPE_SINGE;

    public function getData()
    {
        $this->validate('orderId');

        return [
            'id' => $this->getOrderId()
        ];
    }

    public function setOrderId($id)
    {
        $this->setParameter('orderId', $id);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function createResponse($data)
    {
        if (!isset($data[0])) {
            throw new \Omnipay\Common\Exception\InvalidResponseException('Invalid response from gateway');
        }

        return $this->response = new OrderResponse($this, $data[0]);
    }
}
