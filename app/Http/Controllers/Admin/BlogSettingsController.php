<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show the blog settings form.
     */
    public function index()
    {
        $settings = [
            'site_name' => BlogSetting::get('site_name', config('app.name')),
            'site_logo' => BlogSetting::get('site_logo'),
        ];

        return view('admin.blog-settings.index', compact('settings'));
    }

    /**
     * Update the blog settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update site name
        BlogSetting::set('site_name', $request->site_name);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = BlogSetting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $logoPath = $request->file('site_logo')->store('blog-settings', 'public');
            BlogSetting::set('site_logo', $logoPath, 'image');
        }

        // Clear cache
        BlogSetting::clearCache();

        return redirect()->route('admin.blog-settings.index')
            ->with('success', 'Configuración del blog actualizada correctamente.');
    }

    /**
     * Remove the logo.
     */
    public function removeLogo()
    {
        $logo = BlogSetting::get('site_logo');

        if ($logo) {
            // Delete file
            Storage::disk('public')->delete($logo);

            // Remove from database
            BlogSetting::set('site_logo', null, 'image');

            // Clear cache
            BlogSetting::clearCache();
        }

        return redirect()->route('admin.blog-settings.index')
            ->with('success', 'Logo eliminado correctamente.');
    }
}
