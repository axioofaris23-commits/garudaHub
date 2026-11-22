<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('client')
            ->withCount('bids')
            ->when($request->q, fn ($query, $q) => $query->where('title', 'like', "%{$q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $request->user()->projects()->create($request->validated());

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dibuat.');
    }

    public function show(Project $project)
    {
        $project->load(['client', 'bids.developer', 'winningBid']);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        abort_unless($project->client_id === auth()->id(), 403);

        return view('projects.edit', compact('project'));
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        abort_unless($project->client_id === auth()->id(), 403);

        $project->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Proyek diperbarui.');
    }

    public function destroy(Project $project)
    {
        abort_unless($project->client_id === auth()->id(), 403);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyek dihapus.');
    }
}