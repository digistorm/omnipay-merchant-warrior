<?php

declare(strict_types=1);

namespace Omnipay\MerchantWarrior\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use SimpleXMLElement;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, SimpleXMLElement $data)
    {
        parent::__construct($request, $data);
    }

    public function getTransactionId(): string
    {
        return (string) $this->data->transactionID;
    }

    public function getTransactionReference(): string
    {
        return (string) $this->data->transactionReferenceID;
    }

    public function getMessage(): string
    {
        return (string) $this->data->responseMessage;
    }

    public function isSuccessful(): bool
    {
        return (int) $this->data->responseCode === 0;
    }

    public function getCode(): ?string
    {
        return $this->data->responseCode;
    }

    public function getData(): array
    {
        return json_decode(json_encode($this->data) ?: '', true);
    }
}
