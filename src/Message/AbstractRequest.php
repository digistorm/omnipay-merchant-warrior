<?php

declare(strict_types=1);

namespace Omnipay\MerchantWarrior\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

abstract class AbstractRequest extends CommonAbstractRequest
{
    protected const ENDPOINT_LIVE = 'https://api.merchantwarrior.com/post/';

    protected const ENDPOINT_TEST = 'https://base.merchantwarrior.com/post/';

    /**
     * The http method for the request.
     */
    abstract public function getHttpMethod(): ?string;

    abstract protected function createResponse(mixed $data): ResponseInterface;

    public function getMerchantUUID(): ?string
    {
        return $this->getParameter('merchantUUID');
    }

    public function setMerchantUUID(string $value): void
    {
        $this->setParameter('merchantUUID', $value);
    }

    public function getApiKey(): ?string
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey(string $value): void
    {
        $this->setParameter('apiKey', $value);
    }

    public function getApiPassphrase(): ?string
    {
        return $this->getParameter('apiPassphrase');
    }

    public function setApiPassphrase(string $value): void
    {
        $this->setParameter('apiPassphrase', $value);
    }

    /**
     * @link https://dox.merchantwarrior.com/getting-started#hash-generation
     * @throws InvalidRequestException
     */
    public function getTransactionHash(): string
    {
        $step1 = md5($this->getApiPassphrase()) . $this->getMerchantUUID() . $this->getAmount() . $this->getCurrency();
        $step2 = strtolower($step1);

        return md5($step2);
    }

    public function getCurrency(): string
    {
        return $this->getParameter('currency') ?: 'AUD';
    }

    public function getCustom1(): ?string
    {
        return $this->getParameter('custom1');
    }

    public function setCustom1(string $value): void
    {
        $this->setParameter('custom1', $value);
    }

    public function getCustom2(): ?string
    {
        return $this->getParameter('custom2');
    }

    public function setCustom2(string $value): void
    {
        $this->setParameter('custom2', $value);
    }

    public function getCustom3(): ?string
    {
        return $this->getParameter('custom3');
    }

    public function setCustom3(string $value): void
    {
        $this->setParameter('custom3', $value);
    }

    public function getEndpoint(): ?string
    {
        return $this->getTestMode() ? self::ENDPOINT_TEST : self::ENDPOINT_LIVE;
    }

    public function getStoreID(): ?string
    {
        return $this->getParameter('storeID');
    }

    public function setStoreID(string $value): void
    {
        $this->setParameter('storeID', $value);
    }

    public function sendData(mixed $data): ResponseInterface
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'text/xml'
        ];
        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            http_build_query($data),
        );
        $content = (string) $response->getBody();
        $xml = simplexml_load_string($content);
        $this->response = $this->createResponse($xml);

        return $this->response;
    }

    /**
     * @throws InvalidRequestException
     * @throws InvalidCreditCardException
     */
    protected function getCardData(): array
    {
        $card = $this->getCard();
        $card->validate();

        return [
            'customerName' => $card->getName(),
            'customerCountry' => $card->getCountry() ?: 'AU',
            'customerState' => $card->getState(),
            'customerCity' => $card->getCity(),
            'customerAddress' => $card->getAddress1(),
            'customerPostCode' => $card->getPostcode(),
            'customerEmail' => $card->getEmail(),
            'customerPhone' => $card->getPhone(),
            'paymentCardNumber' => $card->getNumber(),
            'paymentCardExpiry' => $card->getExpiryDate('my'),
            'paymentCardName' => $card->getName(),
            'paymentCardCSC' => $card->getCvv(),
        ];
    }
}
