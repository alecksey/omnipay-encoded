<?php

namespace Omnipay\Encoded\Exception;

use Omnipay\Common\Exception\OmnipayException;

class InvalidValueException extends \InvalidArgumentException implements OmnipayException
{
    public function __construct($currentValue, $mustBe = "", $message = "Invalid value: ", $code = 0, $previous = null)
    {
        parent::__construct($message . var_export($currentValue, true) .
            (($mustBe != '') ? 'must be: ' . $mustBe : '' ), $code, $previous);
    }
}
