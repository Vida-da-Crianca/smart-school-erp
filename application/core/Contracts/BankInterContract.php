<?php 


namespace Application\Core\Contracts;



interface BankInterContract {


    public function getUser();
    public function getUserDocument();
    public function getPrice();
    public function getDocument();
    public function getDescription();
    public function getYourNumber();
    public function getDatePayment();
    public function getAddress();
    public function getAddressCity();
    public function getAddressPostalCode();
    public function getAddressPayment();
    public function getAddressNumber();
    public function getAddressState();
    public function getAddressDistrict();
    public function getDiscount();
    public function getFine();

}