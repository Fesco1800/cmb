<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContactMessage;
class ContactMessageController extends Controller
{
    
    public function index() {
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }


        return view('admin.contact-messages.index', [
            'messages' => ContactMessage::latest()->get()
        ]);
    }

    public function store(Request $request) {

        ContactMessage::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return redirect()->back()->with('message','Successfully submitted.');
    }

    public function destroy(ContactMessage $message) {
        $message->delete();
        return redirect()->back()->with('message','Message deleted successfully.');
    }
}
