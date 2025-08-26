<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of author requests.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');
        $search = $request->input('q');

        $query = User::where('author_request_status', $status);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('author_requested_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.author-requests.index', compact('requests', 'status', 'search'));
    }

    /**
     * Approve an author request.
     */
    public function approve(User $user)
    {
        if ($user->author_request_status !== 'pending') {
            return back()->withErrors(['status' => 'Esta solicitud ya no está pendiente.']);
        }

        $user->approveAuthorRequest();

        return back()->with('success', "Solicitud de {$user->name} aprobada. Ahora es autor.");
    }

    /**
     * Reject an author request.
     */
    public function reject(User $user)
    {
        if ($user->author_request_status !== 'pending') {
            return back()->withErrors(['status' => 'Esta solicitud ya no está pendiente.']);
        }

        $user->rejectAuthorRequest();

        return back()->with('success', "Solicitud de {$user->name} rechazada.");
    }
}
