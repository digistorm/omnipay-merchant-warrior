<?php

namespace Omnipay\MerchantWarrior\Message;

/**
 * @link https://dox.merchantwarrior.com/direct-api#processcard
 * @method PurchaseResponse sendData($data)
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * The reference we want to store for the transaction.
     */
    public function getTransactionProduct()
    {
        return $this->getParameter('transactionProduct');
    }

    /**
     * @param $value
     */
    public function setTransactionProduct($value)
    {
        $this->setParameter('transactionProduct', $value);
    }

    public function getData()
    {
        $this->validate(
            'amount',
            'transactionProduct'
        );

        $data = [
            'method' => 'processCard',
            'merchantUUID' => $this->getMerchantUUID(),
            'apiKey' => $this->getApiKey(),
            'transactionAmount' => $this->getAmount(),
            'transactionCurrency' => $this->getCurrency(),
            'transactionProduct' => $this->getTransactionProduct(),
            'storeID' => $this->getStoreID(),
            'custom1' => $this->getCustom1(),
            'custom2' => $this->getCustom2(),
            'custom3' => $this->getCustom3(),
            'hash' => $this->getTransactionHash()
        ];

        return array_merge($data, $this->getCardData());
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @param $data
     * @return \Omnipay\MerchantWarrior\Message\PurchaseResponse
     */
    protected function createResponse($data)
    {
        return new PurchaseResponse($this, $data);
    }
}
