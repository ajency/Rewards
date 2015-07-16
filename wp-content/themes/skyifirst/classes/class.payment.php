<?php
echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
class payment extends WC_Gateway_Payu_In
{

    public function __construct(){
        parent::__construct();

    }
    public function payment_fields()
    {
        echo "A save";
    }
}

$nw_pay = new payment();
$nw_pay->payment_fields();
