<?php

namespace Omnipay\MerchantWarrior\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, \SimpleXMLElement $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return (string) $this->data->transactionID;
    }

    public function getTransactionReference()
    {
        return (string) $this->data->transactionReferenceID;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return (string) $this->data->responseMessage;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return (int) $this->data->responseCode === 0;
    }

    public function getCode()
    {
        return (int) $this->data->responseCode;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return json_decode(json_encode($this->data), true);
    }
}
