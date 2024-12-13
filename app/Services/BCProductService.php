<?php
namespace App\Services;

use GuzzleHttp\Client;

use App\Models\NewProductNotfication;
use App\Models\ProductBasicDetail;

class BCProductService
{
    public function __construct(){
        $this->endPoint = config('api.bc.endpoint');
        $this->client_id = config('api.bc.client_id');
        $this->client_secret = config('api.bc.client_secret');
    }

    public function get_products()
    {
        $params = "/get-product-details";
        $url = $this->endPoint.$params;

        $client = new Client();

        $response = $client->request('GET', $url, [
            'headers' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            ]
        ]);
        
        return json_decode($response->getBody(), true);
    }

    public function get_product($token){
        $new_product = NewProductNotfication::where("token", $token)->first();

        if($new_product){
            return ProductBasicDetail::where("product_id", $new_product->product_id)->first();
        }else{
            return false;
        }
    }

    public function generateToken($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }

        return $token;
    }
}
