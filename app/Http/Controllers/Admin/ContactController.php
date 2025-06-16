<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $item = Contact::first();

        return view('pages.admin.contact.index', [
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'contact_content' => 'required',
        ]);

        Contact::where('id', $id)
                ->update([
                    'contact_content' => $request->contact_content
                ]);

        return redirect()
                    ->route('contact.index')
                    ->with('success', 'Sukses! Kontak telah diperbarui');
    }
}
