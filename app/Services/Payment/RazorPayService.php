<?php


namespace App\Services\Payment;
use App\Models\Order;
use GuzzleHttp;

class RazorPayService
{

    public $merchantkey='E6crwKPUI8PVPx';
//    protected $api_key='rzp_test_lsZ0lIPq0J82Oe';
//    protected $api_secret='5OwSOl5lR3ijOiFKOs8RodMT';
    protected $api_key='rzp_live_81l9dwMP29tMID';
    protected $api_secret='YwW3mtd3gTP0VmoGr4AreoZz';

    protected $endpoint='https://api.razorpay.com/v1/orders';

    public function __construct(GuzzleHttp\Client $client){
        $this->client=$client;
    }


    public function generateorderid($data){

        try{
            //die('dsd');
            $response = $this->client->post($this->endpoint, [GuzzleHttp\RequestOptions::JSON =>$data, GuzzleHttp\RequestOptions::AUTH => [$this->api_key,$this->api_secret]]);
            //die('dsd');
            $body=$response->getBody()->getContents();

        }catch(GuzzleHttp\Exception\TransferException $e){
            $body=$e->getResponse()->getBody()->getContents();
        }
        return $body;
    }

    public function verifypayment($data){
        $generated_signature = hash_hmac('sha256', $data['razorpay_order_id'] . "|" .$data['razorpay_payment_id'], $this->api_secret);
        //return true;
        if ($generated_signature == $data['razorpay_signature']) {
           return true;
        }
        return false;
    }
}
