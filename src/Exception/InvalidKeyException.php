<?php

namespace Omnipay\Encoded\Exception;

use Omnipay\Common\Exception\OmnipayException;

class InvalidKeyException extends \InvalidArgumentException implements OmnipayException
{
    public function __construct($message = "Invalid Keys", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
