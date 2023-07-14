<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'MerchantWarrior' instanceof \Omnipay\MerchantWarrior\MerchantWarriorGateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'MerchantWarrior' instanceof \Omnipay\MerchantWarrior\MerchantWarriorGateway,
      ],
    ];
}
