<?php

declare(strict_types=1);

namespace Omnipay\MerchantWarrior;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MerchantWarrior\Message\PurchaseRequest;

/**
 * MerchantWarrior Gateway
 */
class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Merchant Warrior';
    }

    public function getDefaultParameters(): array
    {
        return ['MerchantUUID' => '', 'ApiKey' => '', 'ApiPassphrase' => ''];
    }

    public function getMerchantUUID(): string
    {
        return $this->getParameter('MerchantUUID');
    }

    public function setMerchantUUID(string $value): self
    {
        return $this->setParameter('MerchantUUID', $value);
    }

    public function getApiKey(): string
    {
        return $this->getParameter('ApiKey');
    }

    public function setApiKey(string $value): self
    {
        return $this->setParameter('ApiKey', $value);
    }

    public function getApiPassphrase(): string
    {
        return $this->getParameter('ApiPassphrase');
    }

    public function setApiPassphrase(string $value): self
    {
        return $this->setParameter('ApiPassphrase', $value);
    }

    /**
     * Purchase request
     */
    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }
}
