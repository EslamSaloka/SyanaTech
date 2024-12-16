<?php

namespace App\Http\Controllers\Dashboard\ContactUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Contact\CreateNewMessageRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = [
            'title' =>  __("Messages List"),
            'items' =>  [
                [
                    'title' =>  __("Messages List"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Contact::latest()->paginate();
        return view('admin.pages.contact-us.index',[
            'breadcrumb' => $breadcrumb,
            'lists' => $lists,
        ]);
    }

    public function show(Contact $contact_u)
    {
        if($contact_u->seen != 1) {
            $contact_u->update([
                'seen'    => 1
            ]);
        }
        $breadcrumb = [
            'title' =>  __("Show message"),
            'items' =>  [
                [
                    'title' =>  __("Messages List"),
                    'url'   =>  route('admin.contact-us.index'),
                ],
                [
                    'title' =>  __("Show message"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        return view('admin.pages.contact-us.show',[
            'breadcrumb'=>$breadcrumb,
            'contact_u'=>$contact_u,
        ]);
    }

    public function destroy(Request $request,Contact $contact_u)
    {
        $contact_u->delete();
        return redirect()->route('admin.contact-us.index')->with('success', __("This message has been deleted."));
    }
}
