<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the users with role management.
     */
    public function index(Request $request)
    {
        $search = $request->input('q');
        $role = $request->input('role');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role && in_array($role, ['admin', 'author', 'guest'])) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    /**
     * Update a user's role.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,author,guest',
        ]);

        // Prevent demoting the last admin
        if ($user->role === 'admin' && $validated['role'] !== 'admin') {
            $otherAdmins = User::where('role', 'admin')->where('id', '!=', $user->id)->count();
            if ($otherAdmins === 0) {
                return back()->withErrors(['role' => 'No puedes quitar el último administrador.']);
            }
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating yourself
        if ($user->id === auth()->id()) {
            return back()->withErrors(['status' => 'No puedes desactivarte a ti mismo.']);
        }

        // Prevent deactivating the last admin
        if ($user->role === 'admin' && ($user->is_active ?? true)) {
            $activeAdmins = User::where('role', 'admin')
                ->where('id', '!=', $user->id)
                ->where(function($query) {
                    $query->where('is_active', true)
                          ->orWhereNull('is_active');
                })
                ->count();

            if ($activeAdmins === 0) {
                return back()->withErrors(['status' => 'No puedes desactivar el último administrador activo.']);
            }
        }

        $currentStatus = $user->is_active ?? true;
        $user->update(['is_active' => !$currentStatus]);

        $statusText = $currentStatus ? 'desactivado' : 'activado';
        return back()->with('success', "Usuario {$statusText} correctamente.");
    }
}

