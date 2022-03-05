<?php

namespace Omnipay\Encoded\Message\Order;

class GetOrderTransactionsRequest extends \Omnipay\Encoded\Message\AbstractRequest
{
    protected $method = 'GET';

    protected $api_suffix = '/orders';

    protected $query_type = self::GET_QUERY_TYPE_SINGE;

    protected $api_end_url = '/transactions';


    public function getData()
    {
        return [
            'id' => $this->getOrderId()
        ];
    }

    public function setOrderId($id)
    {
        $this->setParameter('orderId', $id);

        return $this;
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }
}
