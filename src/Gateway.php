<?php

namespace Omnipay\MerchantWarrior;

use Omnipay\Common\AbstractGateway;
use Omnipay\MerchantWarrior\Message\PurchaseRequest;

/**
 * MerchantWarrior Gateway
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Merchant Warrior';
    }

    public function getDefaultParameters()
    {
        return array(
            'MerchantUUID' => '',
            'ApiKey' => '',
            'ApiPassphrase' => '',
        );
    }

    public function getMerchantUUID()
    {
        return $this->getParameter('MerchantUUID');
    }

    public function setMerchantUUID($value)
    {
        return $this->setParameter('MerchantUUID', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('ApiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('ApiKey', $value);
    }

    public function getApiPassphrase()
    {
        return $this->getParameter('ApiPassphrase');
    }

    public function setApiPassphrase($value)
    {
        return $this->setParameter('ApiPassphrase', $value);
    }

    /**
     * Purchase request
     *
     * @param array $parameters
     * @return \Omnipay\MerchantWarrior\Message\PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }
}
