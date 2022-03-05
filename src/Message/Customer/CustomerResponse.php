<?php

namespace Omnipay\Encoded\Message\Customer;

class CustomerResponse extends \Omnipay\Encoded\Message\Response
{
    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    public function getReference()
    {
        return $this->data['ref'];
    }

    public function getTitle()
    {
        return $this->data['title'];
    }

    public function getForename()
    {
        return $this->data['forename'];
    }

    public function getSurname()
    {
        return $this->data['surname'];
    }

    public function getDateOfBirth()
    {
        return $this->data['dateOfBirth'];
    }

    public function getContact()
    {
        return $this->data['contact'];
    }

    public function getEmail()
    {
        return $this->data['email'];
    }

}
