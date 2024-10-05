<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contactUs(){
        return view('user.contact.contactUs');
    }

    public function contactList(){
        $contacts = Contact::paginate('5');
        return view('admin.contact.contactList',compact('contacts'));
    }

    public function ContactDelete($id){
        Contact::where('id',$id)->delete();
        return redirect()->route('admin#contactList');
    }

    public function SendMail(Request $request){
        $this->productValidationCheck($request);
        $data = $this->requestContactInfo($request);

        Contact::create($data);
        return redirect()->route('user#contactUs');
    }

    private function requestContactInfo($request){
        return[
            'name' => $request->contactName,
            'email' =>$request->contactEmail,
            'message'=>$request->contactMessage
        ];
    }

    //product Validation Check
    private function productValidationCheck($request){
        Validator::make($request->all(),[
            'contactName' => 'required',
            'contactEmail' => 'required',
            'contactMessage' => 'required'
        ])->validate();
    }
}
