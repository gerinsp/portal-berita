<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\App;

use Illuminate\Support\Facades\Storage;

class AppsController extends Controller
{
    public function index()
    {
        $item = App::first();

        return view('pages.admin.apps.index', [
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'link_web' => 'required',
        ]);

        App::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'title' => $request->title,
                    'description' => $request->description,
                    'link_web' => $request->link_web,
                ]);

        return redirect()
                    ->route('apps.index')
                    ->with('success', 'Sukses! Data aplikasi telah diperbarui');
    }

    public function update_logo(Request $request, $id)
    {
        $validatedData = $request->validate([
            'logo' => 'image|file|max:1024',
        ]);

        $item = App::findOrFail($id);

        if($request->file('logo')){
            Storage::delete($item->logo);
            $validatedData['logo'] = $request->file('logo')->store('assets/apps');
        }

        $item->update($validatedData);

        return redirect()
                    ->route('apps.index')
                    ->with('success-logo', 'Sukses! Logo aplikasi telah diperbarui');
    }

    public function update_favicon(Request $request, $id)
    {
        $validatedData = $request->validate([
            'favicon' => 'image|file|max:1024',
        ]);

        $item = App::findOrFail($id);

        if($request->file('favicon')){
            Storage::delete($item->favicon);
            $validatedData['favicon'] = $request->file('favicon')->store('assets/apps');
        }

        $item->update($validatedData);

        return redirect()
                    ->route('apps.index')
                    ->with('success-favicon', 'Sukses! Favicon aplikasi telah diperbarui');
    }
}
