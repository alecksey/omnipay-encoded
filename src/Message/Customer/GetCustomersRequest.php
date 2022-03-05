<?php

namespace Omnipay\Encoded\Message\Customer;

class GetCustomersRequest extends \Omnipay\Encoded\Message\AbstractRequest
{

    protected $api_suffix = '/customers';

    protected $method = 'GET';

    protected $query_type = self::GET_QUERY_TYPE_MULTI;

    public function getData()
    {
        $this->validate('page', 'results');
        return [
            'page' => $this->getPage(),
            'results' => $this->getResults()
        ];
    }

    public function setPage($page)
    {

        $this->setParameter('pgae', $page);

        return $this;
    }

    public function getPage()
    {
        return $this->getParameter('page');
    }

    public function setResults($results)
    {
        $this->setParameter('results', $results);
    }

    public function getResults()
    {
        return $this->getParameter('results');
    }
}
