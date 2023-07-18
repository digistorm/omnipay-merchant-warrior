<?php

namespace Omnipay\MerchantWarrior\Message;

use Omnipay\Common\Exception\InvalidRequestException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://api.merchantwarrior.com/post/';
    protected $testEndpoint = 'https://base.merchantwarrior.com/post/';

    /**
     * The http method for the request.
     */
    abstract public function getHttpMethod();

    abstract protected function createResponse($data);

    /**
     * @return string
     */
    public function getMerchantUUID()
    {
        return $this->getParameter('merchantUUID');
    }

    /**
     * @param string $value
     */
    public function setMerchantUUID($value)
    {
        $this->setParameter('merchantUUID', $value);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param string $value
     */
    public function setApiKey($value)
    {
        $this->setParameter('apiKey', $value);
    }

    /**
     * @return string
     */
    public function getApiPassphrase()
    {
        return $this->getParameter('apiPassphrase');
    }

    /**
     * @param string $value
     */
    public function setApiPassphrase($value)
    {
        $this->setParameter('apiPassphrase', $value);
    }

    /**
     * @link https://dox.merchantwarrior.com/getting-started#hash-generation
     * @return string
     * @throws InvalidRequestException
     */
    public function getTransactionHash()
    {
        $step1 = md5($this->getApiPassphrase()) . $this->getMerchantUUID() . $this->getAmount() . $this->getCurrency();
        $step2 = strtolower($step1);

        return md5($step2);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        $currency = parent::getCurrency();

        return empty($currency) ? 'AUD' : $currency;
    }

    /**
     * @return string
     */
    public function getCustom1()
    {
        return $this->getParameter('custom1');
    }

    public function setCustom1($value)
    {
        $this->setParameter('custom1', $value);
    }

    /**
     * @return string
     */
    public function getCustom2()
    {
        return $this->getParameter('custom2');
    }

    public function setCustom2($value)
    {
        $this->setParameter('custom2', $value);
    }

    /**
     * @return string
     */
    public function getCustom3()
    {
        return $this->getParameter('custom3');
    }

    public function setCustom3($value)
    {
        $this->setParameter('custom3', $value);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getStoreID()
    {
        return $this->getParameter('storeID');
    }

    public function setStoreID($value)
    {
        $this->setParameter('storeID', $value);
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'text/xml',
        ];
        $response = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, http_build_query($data));
        $content = (string) $response->getBody();
        $xml = simplexml_load_string($content);
        $this->response = $this->createResponse($xml);

        return $this->response;
    }

    protected function getCardData()
    {
        $card = $this->getCard();
        $card->validate();

        return [
            'customerName' => $card->getName(),
            'customerCountry' => $card->getCountry() ?? 'AU',
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
