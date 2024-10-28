<?php

declare(strict_types=1);

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
    public function getTransactionProduct(): string
    {
        return $this->getParameter('transactionProduct');
    }

    public function setTransactionProduct(string $value): void
    {
        $this->setParameter('transactionProduct', $value);
    }

    public function getData(): array
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
            'hash' => $this->getTransactionHash(),
        ];

        return array_merge($data, $this->getCardData());
    }

    public function getHttpMethod(): string
    {
        return 'POST';
    }

    protected function createResponse(mixed $data): PurchaseResponse
    {
        return new PurchaseResponse($this, $data);
    }
}
