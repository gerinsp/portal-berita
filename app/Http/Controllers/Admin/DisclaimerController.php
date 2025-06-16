<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Disclaimer;

class DisclaimerController extends Controller
{

    public function index()
    {
        $item = Disclaimer::first();

        return view('pages.admin.disclaimer.index', [
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'disclaimer_content' => 'required',
        ]);

        Disclaimer::where('id', $id)
                ->update([
                    'disclaimer_content' => $request->disclaimer_content
                ]);

        return redirect()
                    ->route('disclaimer.index')
                    ->with('success', 'Sukses! Disclaimer telah diperbarui');
    }

}
