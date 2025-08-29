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
            'navbar_text' => BlogSetting::get('navbar_text', config('app.name')),
            'header_text' => BlogSetting::get('header_text', config('app.name')),
            'footer_text' => BlogSetting::get('footer_text', config('app.name')),
            'footer_logo' => BlogSetting::get('footer_logo'),
            'site_description' => BlogSetting::get('site_description', 'Tu fuente confiable de información sobre tecnología, programación y desarrollo web.'),
        ];

        return view('admin.blog-settings.index', compact('settings'));
    }

    /**
     * Update the blog settings.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'site_name' => 'required|string|max:255',
                'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'navbar_text' => 'required|string|max:255',
                'header_text' => 'required|string|max:255',
                'footer_text' => 'required|string|max:255',
                'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'site_description' => 'required|string|max:500',
            ]);

            // Update text settings
            BlogSetting::set('site_name', $request->site_name);
            BlogSetting::set('navbar_text', $request->navbar_text);
            BlogSetting::set('header_text', $request->header_text);
            BlogSetting::set('footer_text', $request->footer_text);
            BlogSetting::set('site_description', $request->site_description);

            // Handle site logo upload
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

            // Handle footer logo upload
            if ($request->hasFile('footer_logo')) {
                // Delete old footer logo if exists
                $oldFooterLogo = BlogSetting::get('footer_logo');
                if ($oldFooterLogo) {
                    Storage::disk('public')->delete($oldFooterLogo);
                }

                // Store new footer logo
                $footerLogoPath = $request->file('footer_logo')->store('blog-settings', 'public');
                BlogSetting::set('footer_logo', $footerLogoPath, 'image');
            }

            // Clear cache
            BlogSetting::clearCache();

            return redirect()->route('admin.blog-settings.index')
                ->with('success', 'Configuración del blog actualizada correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.blog-settings.index')
                ->with('error', 'Error al actualizar la configuración: ' . $e->getMessage());
        }
    }

    /**
     * Remove the logo.
     */
    public function removeLogo()
    {
        try {
            $logo = BlogSetting::get('site_logo');

            if ($logo) {
                // Delete file
                Storage::disk('public')->delete($logo);

                // Remove from database
                BlogSetting::set('site_logo', null, 'image');

                // Clear cache
                BlogSetting::clearCache();

                return redirect()->route('admin.blog-settings.index')
                    ->with('success', 'Logo eliminado correctamente.');
            }

            return redirect()->route('admin.blog-settings.index')
                ->with('info', 'No hay logo para eliminar.');

        } catch (\Exception $e) {
            return redirect()->route('admin.blog-settings.index')
                ->with('error', 'Error al eliminar el logo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the footer logo.
     */
    public function removeFooterLogo()
    {
        try {
            $logo = BlogSetting::get('footer_logo');

            if ($logo) {
                // Delete file
                Storage::disk('public')->delete($logo);

                // Remove from database
                BlogSetting::set('footer_logo', null, 'image');

                // Clear cache
                BlogSetting::clearCache();

                return redirect()->route('admin.blog-settings.index')
                    ->with('success', 'Logo del footer eliminado correctamente.');
            }

            return redirect()->route('admin.blog-settings.index')
                ->with('info', 'No hay logo del footer para eliminar.');

        } catch (\Exception $e) {
            return redirect()->route('admin.blog-settings.index')
                ->with('error', 'Error al eliminar el logo del footer: ' . $e->getMessage());
        }
    }
}
