<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class FireBase {

    protected $serverToken      = ""; // Fire Base Server Key
    protected $serverUrl        = "https://fcm.googleapis.com/fcm/send"; // Fire Base URL
    protected $title            = "";
    protected $body             = "";
    protected $token            = [];
    protected $by               = "system";
    protected $send_to_all      = false;
    protected $target_screen    = "Home";
    protected $target_id        = 0;

    public function __construct()
    {
        $this->serverToken = env('FIREBASE_TOKEN');
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    public function setSendToAll($send_to_all)  {
        $this->send_to_all   = $send_to_all;
        return $this;
    }

    public function setTargetScreen($target_screen)  {
        $this->target_screen   = $target_screen;
        return $this;
    }

    public function setTargetId($target_id)  {
        $this->target_id   = $target_id;
        return $this;
    }

    public function setToken($token) {
        $this->token = is_array($token) ? $token : [$token];
        return $this;
    }

    private function getHeaders() {
        return [
            'Content-Type: application/json',
            'Authorization: key='.$this->serverToken,
        ];
    }

    private function getData()
    {
        return [
            'title'         => $this->title,
            'body'          => $this->body,
            'target_screen' => $this->target_screen,
            'target_id'     => $this->target_id,
            'vibrate'       => 1,
            'sound'         => 1,
        ];
    }

    private function getFields()
    {
        if($this->send_to_all) { //send to all
            $fields = [
                'notification' => $this->getData(),
                'to'    => '/topics/General'
            ];
        } else { //send to specific users
            $fields = [
                'notification'      => $this->getData(),
                'registration_ids'  => $this->token
            ];
        }
        return $fields;
    }

    public function build()
    {
        $ch = curl_init( $this->serverUrl );
        $data = json_encode($this->getFields(), true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->getHeaders() );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}
