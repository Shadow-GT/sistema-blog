<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of contacts and consultas combined.
     */
    public function index(Request $request)
    {
        $search = $request->input('q');
        $source = $request->input('source'); // 'personal', 'servicios', or null for all
        $perPage = 20;

        // Get contacts (Personal Web)
        $contactsQuery = Contact::query();
        if ($search) {
            $contactsQuery->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mensaje', 'like', "%{$search}%");
            });
        }

        // Get consultas (Servicios)
        $consultasQuery = Consulta::query();
        if ($search) {
            $consultasQuery->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('mensaje', 'like', "%{$search}%");
            });
        }

        // Filter by source if specified
        if ($source === 'personal') {
            $contacts = $contactsQuery->get()->map(fn($c) => $this->mapContact($c, 'personal'));
            $all = $contacts;
        } elseif ($source === 'servicios') {
            $consultas = $consultasQuery->get()->map(fn($c) => $this->mapContact($c, 'servicios'));
            $all = $consultas;
        } else {
            $contacts = $contactsQuery->get()->map(fn($c) => $this->mapContact($c, 'personal'));
            $consultas = $consultasQuery->get()->map(fn($c) => $this->mapContact($c, 'servicios'));
            $all = $contacts->concat($consultas);
        }

        // Sort by date descending
        $sorted = $all->sortByDesc('created_at');

        // Manual pagination
        $page = $request->input('page', 1);
        $items = $sorted->forPage($page, $perPage);
        $messages = new LengthAwarePaginator($items, $sorted->count(), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // Stats
        $stats = [
            'total' => Contact::count() + Consulta::count(),
            'personal' => Contact::count(),
            'servicios' => Consulta::count(),
            'today' => Contact::whereDate('created_at', today())->count() +
                       Consulta::whereDate('created_at', today())->count(),
        ];

        return view('admin.contacts.index', compact('messages', 'search', 'stats', 'source'));
    }

    /**
     * Map a contact/consulta to a unified format.
     */
    private function mapContact($item, $source)
    {
        return (object) [
            'id' => $item->id,
            'nombre' => $item->nombre,
            'email' => $item->email,
            'telefono' => $item->telefono ?? null,
            'mensaje' => $item->mensaje,
            'short_message' => $item->short_message,
            'ip_address' => $item->ip_address,
            'user_agent' => $item->user_agent,
            'created_at' => $item->created_at,
            'source' => $source,
        ];
    }

    /**
     * Display the specified message.
     */
    public function show(Request $request, $id)
    {
        $source = $request->query('source', 'personal');

        if ($source === 'servicios') {
            $item = Consulta::findOrFail($id);
            $message = $this->mapContact($item, 'servicios');
        } else {
            $item = Contact::findOrFail($id);
            $message = $this->mapContact($item, 'personal');
        }

        return view('admin.contacts.show', compact('message'));
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy(Request $request, $id)
    {
        $source = $request->query('source', 'personal');

        if ($source === 'servicios') {
            Consulta::findOrFail($id)->delete();
        } else {
            Contact::findOrFail($id)->delete();
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Mensaje eliminado correctamente.');
    }
}

