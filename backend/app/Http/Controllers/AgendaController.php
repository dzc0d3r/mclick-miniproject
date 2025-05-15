<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class AgendaController extends Controller
{
    public function index(): View
    {
        $agendas = Agenda::with('users')->latest()->paginate(10);
        return view('agendas.index', compact('agendas'));
    }

    public function create(): View
    {
        Gate::authorize('create', Agenda::class);
        return view('agendas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Agenda::class);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $agenda = Agenda::create($validated);
        $agenda->users()->attach(auth()()->user()->id);

        return redirect()->route('agendas.index')
            ->with('success', 'Agenda created successfully');
    }

    public function show(Agenda $agenda): View
    
    {
        Gate::authorize('view', $agenda);

        return view('agendas.show', compact('agenda'));
    }

    public function edit(Agenda $agenda): View
    {
        Gate::authorize('update', $agenda);
        return view('agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda): RedirectResponse
    {
        Gate::authorize('update', $agenda);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $agenda->update($validated);
        return redirect()->route('agendas.index')
            ->with('success', 'Agenda updated successfully');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        Gate::authorize('delete', $agenda);
        $agenda->delete();
        return redirect()->route('agendas.index')
            ->with('success', 'Agenda deleted successfully');
    }
}