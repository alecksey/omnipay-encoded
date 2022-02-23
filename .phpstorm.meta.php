<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'Encoded' instanceof \Omnipay\Encoded\ServerGateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'Encoded' instanceof \Omnipay\Encoded\ServerGateway,
      ],
    ];
}
