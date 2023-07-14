<?php

namespace Omnipay\MerchantWarrior;

use Omnipay\Common\AbstractGateway;

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
}
