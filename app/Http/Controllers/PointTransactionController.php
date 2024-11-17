<?php

namespace App\Http\Controllers;

use App\Models\HouseTeam;
use App\Models\PointTransaction;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class PointTransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'points' => 'required|integer',
            'reason' => 'nullable|string',
            'team_member_name' => 'required|string|max:255',
            'house_team_id' => 'required|exists:house_teams,id',
        ]);

        // Find or create the team member
        $teamMember = TeamMember::firstOrCreate(['name' => $validated['team_member_name']]);

        // Attach team member to house team
        $houseTeam = HouseTeam::findOrFail($validated['house_team_id']);
        $houseTeam->teamMembers()->syncWithoutDetaching([$teamMember->id]);

        // Create the point transaction
        $pointTransaction = PointTransaction::create([
            'points' => $validated['points'],
            'reason' => $validated['reason'],
            'team_member_id' => $teamMember->id,
            'house_team_id' => $houseTeam->id,
        ]);

        return response()->json($pointTransaction, 201);
    }
}

