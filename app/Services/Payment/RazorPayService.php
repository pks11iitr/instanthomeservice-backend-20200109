<?php


namespace App\Services\Payment;
use App\Models\Order;
use GuzzleHttp;

class RazorPayService
{

    public $merchantkey='DxCrP29zvAEhzg';
    protected $api_key='rzp_test_kf3QvTFV9UzH7r';
    protected $api_secret='0zHqAAY4ywkGv9GfTZPigPN6';
//    protected $api_key='rzp_live_SChlKx3R6N9pbQ';
//    protected $api_secret='jN3glUfRh4UhxcsUKQ2AL1VG';

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
        //$generated_signature = hash_hmac('sha256', $data['razorpay_order_id'] + "|" + $data['razorpay_payment_id'], $this->api_secret);
        return true;
        if ($generated_signature == $data['razorpay_signature']) {
           return true;
        }
        return false;
    }
}
