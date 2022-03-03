<?php

namespace Omnipay\Encoded\Exception;

use Omnipay\Common\Exception\OmnipayException;

class RecordExistsException extends \InvalidArgumentException implements OmnipayException
{
    public function __construct($message = "Record exists", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
