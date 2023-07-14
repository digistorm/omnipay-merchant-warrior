<?php

namespace Omnipay\MerchantWarrior\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function getTransactionId()
    {
        return (string) $this->data['transactionID'];
    }

    public function getReceiptNo()
    {
        return (string) $this->data['receiptNo'];
    }

    public function getCode()
    {
        return (string) $this->data['authResponseCode'];
    }

    public function getAuthCode()
    {
        return (string) $this->data['authCode'];
    }

    public function getAuthSettledDate()
    {
        return (string) $this->data['authSettledDate'];
    }

    public function getMessage()
    {
        return (string) $this->data['responseMessage'];
    }

    public function isSuccessful()
    {
        return (int) $this->data['responseCode'] === 0;
    }
}
