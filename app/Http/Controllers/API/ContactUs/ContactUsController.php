<?php

namespace App\Http\Controllers\API\ContactUs;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\API\ContactUs\ContactUsRequest;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Contact;

class ContactUsController extends Controller
{
    public function store(ContactUsRequest $request) {
        Contact::create([
            'user_id'       => \Auth::user()->id,
            'message_type'  => $request->message_type,
            'message'       => $request->message,
        ]);
        return (new API)->isOk(__("Thank for send message"))->build();
    }
}
