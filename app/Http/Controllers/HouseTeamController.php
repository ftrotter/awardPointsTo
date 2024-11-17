<?php

namespace App\Http\Controllers;

use App\Models\HouseTeam;
use Illuminate\Http\Request;

class HouseTeamController extends Controller
{
    public function index(Request $request)
    {
        $houseTeams = $request->user()->houseTeams()
            ->with('teamMembers', 'pointTransactions')
            ->get()
            ->map(function ($houseTeam) {
                $houseTeam->total_points = $houseTeam->total_points;
                return $houseTeam;
            });

        return response()->json($houseTeams);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $houseTeam = $request->user()->houseTeams()->create($validated);

        return response()->json($houseTeam, 201);
    }

    public function show(Request $request, $id)
    {
        $houseTeam = $request->user()->houseTeams()
            ->with('teamMembers', 'pointTransactions')
            ->findOrFail($id);

        $houseTeam->total_points = $houseTeam->total_points;

        return response()->json($houseTeam);
    }

    public function update(Request $request, $id)
    {
        $houseTeam = $request->user()->houseTeams()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $houseTeam->update($validated);

        return response()->json($houseTeam);
    }

    public function destroy(Request $request, $id)
    {
        $houseTeam = $request->user()->houseTeams()->findOrFail($id);
        $houseTeam->delete();

        return response()->json(null, 204);
    }

    public function teamMembers($id)
    {
        $houseTeam = HouseTeam::with('teamMembers')->findOrFail($id);
        return response()->json($houseTeam->teamMembers);
    }
}

