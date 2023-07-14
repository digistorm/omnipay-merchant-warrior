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
    public function getTransactionID()
    {
        return (string) $this->data->transactionID;
    }

    /**
     * @return string
     */
    public function getReceiptNo()
    {
        return (string) $this->data->receiptNo;
    }

    /**
     * @return string
     */
    public function getAuthMessage()
    {
        return (string) $this->data->authMessage;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return (int) $this->data->responseCode === 0;
    }
}
