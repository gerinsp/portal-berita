<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Redaction;

class RedactionController extends Controller
{
    public function index()
    {
        $item = Redaction::first();

        return view('pages.admin.redaction.index', [
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'redaction_content' => 'required',
        ]);

        Redaction::where('id', $id)
                ->update([
                    'redaction_content' => $request->redaction_content
                ]);

        return redirect()
                    ->route('redaction.index')
                    ->with('success', 'Sukses! Redaksi telah diperbarui');
    }

}
