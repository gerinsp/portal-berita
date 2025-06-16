<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Guideline;

class GuidelineController extends Controller
{

    public function index()
    {
        $item = Guideline::first();

        return view('pages.admin.guidline.index', [
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guideline_content' => 'required',
        ]);

        Guideline::where('id', $id)
                ->update([
                    'guideline_content' => $request->guideline_content
                ]);

        return redirect()
                    ->route('guideline.index')
                    ->with('success', 'Sukses! Pedoman telah diperbarui');
    }

}
