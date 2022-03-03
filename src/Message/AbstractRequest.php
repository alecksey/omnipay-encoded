<?php

namespace Omnipay\Encoded\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    const API_VERSION = 'v1';
    protected $liveEndpoint = 'https://live.encoded.services';
    protected $testEndpoint = 'https://sit.encoded.services';
    protected $auth_token = null;

    protected $api_suffix = '/';

    protected $api_end_url = '';

    protected $method = 'GET';

    protected $query_type = self::GET_QUERY_TYPE_SINGE;

    /**
     * Used for get entity request, exmaple for: GET /transactions/{id}, also can be used for DELETE request
     */
    const GET_QUERY_TYPE_SINGE = 0;

    /**
     * Used for filtered GET request, with query like ?field1=val1&field2=val2
     */
    const GET_QUERY_TYPE_MULTI = 1;

    /**
     * None params required for GET request
     */
    const GET_QUERY_TYPE_EMPTY = 2;

    const METHOD_POST = 'POST';

    const METHOD_GET = 'GET';

    const METHOD_DELETE = 'DELETE';

    const METHOD_PUT = 'PUT';


    public function getAccessKey()
    {
        return $this->getParameter('access_key');
    }

    public function setAccessKey($value)
    {
        return $this->setParameter('access_key', $value);
    }

    public function getAccessSecret()
    {
        return $this->getParameter('access_secret');
    }

    public function setAccessSecret($value)
    {
        return $this->setParameter('access_secret', $value);
    }

    public function sendData($data)
    {
        $this->auth();
        if (null === $this->auth_token) {
            throw new \Exception('Invalid auth token');
        }

        $url = $this->getEndpoint() . '/api/' . self::API_VERSION . $this->api_suffix;

        switch ($this->method) {
            case self::METHOD_POST:
            case self::METHOD_PUT:
                $response = $this->httpClient->request(
                    $this->method,
                    $url . $this->api_end_url,
                    [
                        'Authorization' => 'Bearer ' . $this->auth_token,
                        'Content-Type' => 'application/json'
                    ],
                    json_encode($data)

                );
                break;
            case self::METHOD_DELETE:
            case self::METHOD_GET:
                switch ($this->query_type) {
                    case self::GET_QUERY_TYPE_SINGE:
                        $url = $url . '/' . $data['id'];
                        $response = $this->httpClient->request(
                            'GET',
                            $url . $this->api_end_url,
                            [
                                'Authorization' => 'Bearer ' . $this->auth_token,
                            ]
                        );
                        break;
                    case self::GET_QUERY_TYPE_MULTI:
                        $url = $url . '?' . http_build_query($data);

                        $response = $this->httpClient->request(
                            'GET',
                            $url . $this->api_end_url,
                            [
                                'Authorization' => 'Bearer ' . $this->auth_token,
                            ]
                        );
                        break;
                    case self::GET_QUERY_TYPE_EMPTY:
                        $response = $this->httpClient->request(
                            'GET',
                            $url . $this->api_end_url,
                            [
                                'Authorization' => 'Bearer ' . $this->auth_token,
                            ]
                        );
                        break;
                }
                break;
            default:
                throw  new \Exception();

        }


        $content = $response->getBody()->getContents();

        if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
            $response_data = json_decode($content, true);
            return $this->createResponse($response_data);
        } else {

            var_dump($url, $response->getStatusCode(), $content);
            if ($content !== '') {
                $error_data = json_decode($content, true);

                if(isset($error_data['additionalInfo']['existingRefs'])) {
                    throw new \Omnipay\Encoded\Exception\RecordExistsException();
                }
                throw  new \Omnipay\Common\Exception\InvalidRequestException(
                    $error_data['message']
                );
            } else {
                throw  new \Omnipay\Common\Exception\InvalidRequestException(
                    'Invalid request or gateway error'
                );
            }
        }

    }

    protected function auth()
    {
        if ($this->auth_token === null) {
            if (is_string($this->getAccessKey()) && !empty($this->getAccessKey()) &&
                is_string($this->getAccessSecret()) && !empty($this->getAccessSecret())) {
                $url = $this->getEndpoint() . '/auth/oauth/token?grant_type=client_credentials';
                $auth_token = base64_encode($this->getAccessKey() . ':' . $this->getAccessSecret());


                $res = $this->httpClient->request('POST', $url, [
                    'Authorization' => 'Basic ' . $auth_token
                ]);

                $data = json_decode($res->getBody(), true);
                if (is_array($data) && isset($data['access_token'])) {
                    $this->auth_token = $data['access_token'];
                } else {
                    throw new \Omnipay\Common\Exception\InvalidRequestException('Invalid auth request');
                }
            } else {
                throw new \Omnipay\Encoded\Exception\InvalidKeyException();
            }
        }

        return $this;
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }

    protected function getBaseData()
    {
        return [
            //   'transaction_id' => $this->getTransactionId(),
            //   'expire_date' => $this->getCard()->getExpiryDate('mY'),
            //   'start_date' => $this->getCard()->getStartDate('mY'),
        ];
    }
}
