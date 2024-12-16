<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class SMS {

    // ============================= //
    protected $vendorUrl    = "https://el.cloud.unifonic.com"; // SMS Vendor Url
    protected $appsid       = "g7OhosJGadWQjeZDZoPCX0gFqG8Qmm"; // SMS appsid
    protected $sender       = "Soan"; // SMS Sender
    // ============================= //
    protected $message      = ""; // Message Text
    protected $phone        = ""; // Phone Number

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function getFields() {
        $field = [
            "appsid"        =>  $this->appsid,
            "sender"        =>  $this->sender,
            "to"            =>  $this->phone,
            "msg"           =>  __("Otp for Soan app")." : ".$this->message,
            "baseEncode"    =>  false,
            "encoding"      =>  "UCS2",
        ];
        return http_build_query($field);
    }

    public function build() {
        return Http::get($this->vendorUrl."/wrapper/sendSMS.php", $this->getFields())->json();
    }
}