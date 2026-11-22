<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    // Developer mengajukan penawaran
    public function store(Request $request, Project $project)
    {
        abort_unless($project->status === 'open', 403);

        if ($project->bid_deadline->isPast()) {
            return back()->withErrors(['bid' => 'Batas lelang sudah lewat.']);
        }

        if ($project->bids()->where('developer_id', $request->user()->id)->exists()) {
            return back()->withErrors(['bid' => 'Kamu sudah mengajukan penawaran untuk proyek ini.']);
        }

        $data = $request->validate([
            'price'         => ['required', 'integer', 'min:1'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'proposal'      => ['required', 'string'],
        ]);

        $project->bids()->create($data + ['developer_id' => $request->user()->id]);

        return back()->with('success', 'Penawaran terkirim.');
    }

    // Klien memilih pemenang
    public function accept(Bid $bid)
    {
        $project = $bid->project;

        abort_unless($project->client_id === auth()->id(), 403);
        abort_unless($project->status === 'open', 403);

        DB::transaction(function () use ($bid, $project) {
            $project->bids()->update(['status' => 'rejected']);
            $bid->update(['status' => 'accepted']);
            $project->update([
                'status'         => 'awarded',
                'winning_bid_id' => $bid->id,
            ]);
        });

        return back()->with('success', 'Pemenang dipilih.');
    }
}