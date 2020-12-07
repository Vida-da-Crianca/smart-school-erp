<?php

namespace Application\Core;

use Application\Core\Contracts\BankInterContract;

class BankInterPayment implements BankInterContract
{

    public $payment = null;

    public function getUser()
    {
        return $this->payment->user;
    }
    public function getUserDocument()
    {
        return $this->payment->user_document;
    }
    public function getPrice()
    {
        return $this->payment->price;
    }
    public function getDocument()
    {
        return $this->payment->document;
    }
    public function getDescription()
    {
        return isset($this->payment->description) ? $this->payment->description : '' ;
    }

    public function getDiscount(){
        isset($this->payment->discount) ? $this->payment->discount : '' ;
    }
    
    public function getFine(){
        isset($this->payment->fine) ? $this->payment->fine : '' ;
    
    } 
    public function getYourNumber()
    {
        return $this->payment->your_number;
    }
    public function getDatePayment()
    {
        return $this->payment->date_payment;
    }
    public function getAddress()
    {
        return $this->payment->address;
    }
    public function getAddressCity()
    {
        return $this->payment->address_city;
    }
    public function getAddressPostalCode()
    {
        return $this->payment->address_postal_code;
    }
    public function getAddressPayment()
    {
        return $this->payment->address_postal_payment;
    }
    public function getAddressNumber()
    {
        return $this->payment->address_number;
    }
    public function getAddressState()
    {
        return $this->payment->address_state;
    }
    public function getAddressDistrict()
    {
        return $this->payment->address_district;
    }


    public function __set($name, $value)
    {
       @$this->payment->{$name} = $value;
    }
}
