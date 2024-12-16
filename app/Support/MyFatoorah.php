<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class MyFatoorah {

    protected $token  = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";
    protected $apiURL = "https://apitest.myfatoorah.com";
    protected $fields = [];

    public function __construct() {
        if(env("MYFATOORA_LIVE")) {
            $this->token    = env("MYFATOORA_TOKEN");
            // $this->apiURL   = "https://api.myfatoorah.com";
            $this->apiURL   = "https://api-sa.myfatoorah.com/";
        }
    }


    public function getFields($due) {
        $this->fields = [
            'CustomerName'       => $due->provider->provider_name ?? $due->provider->first_name,
            'NotificationOption' => 'All',
            'MobileCountryCode'  => '966',
            'CustomerMobile'     => substr($due->provider->phone,3),
            'CustomerEmail'      => $due->provider->email,
            'InvoiceValue'       => ($due->total == 0) ? 1 : $due->total,
            'DisplayCurrencyIso' => 'SAR',
            'CallBackUrl'        => url("/api/callback"),
            'ErrorUrl'           => url("/api/callback"),
            'Language'           => 'en',
            'CustomerReference'  => $due->id,
        ];
        return $this;
    }

    public function sendPayment() {
        $data = Http::withHeaders([
            "Authorization" => "Bearer ".$this->token,
            "Content-Type"  => "application/json"
        ])->post($this->apiURL."/v2/SendPayment",$this->fields)->json();
        // dd($data);
        if($data ["IsSuccess"] == false) {
            return [
                "status"      => $data["IsSuccess"],
                "message"     => $data["Message"],
            ];
        }
        return [
            "status"      => $data["IsSuccess"],
            "invoiceId"   => $data["Data"]["InvoiceId"],
            "InvoiceURL"  => $data["Data"]["InvoiceURL"],
        ];
    }


    public function callBack($paymentId) {
        $data = Http::withHeaders([
            "Authorization" => "Bearer ".$this->token,
            "Content-Type"  => "application/json"
        ])->post($this->apiURL."/v2/getPaymentStatus",[
            'KeyType' => 'PaymentId',
            'Key' => $paymentId,
        ])->json();
        return $data;
    }
}
