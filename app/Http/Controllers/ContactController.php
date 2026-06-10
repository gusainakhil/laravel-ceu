<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(ContactRequest $request)
    {
        ContactEnquiry::create(array_merge($request->validated(), [
            'ip_address' => $request->ip(),
            'status' => 'new'
        ]));

        return redirect()->route('contact.index')->with('success', 'Thank you for your message! Our compliance team will get back to you shortly.');
    }
}
