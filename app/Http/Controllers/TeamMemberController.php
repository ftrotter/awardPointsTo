<?php
namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::with('houseTeams', 'pointTransactions')->get();

        $teamMembers = $teamMembers->map(function ($member) {
            $member->total_points = $member->total_points;
            $member->points_per_house_team = $member->getPointsPerHouseTeam();
            return $member;
        });

        return response()->json($teamMembers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $teamMember = TeamMember::create($validated);

        return response()->json($teamMember, 201);
    }

    public function show($id)
    {
        $teamMember = TeamMember::with('houseTeams', 'pointTransactions')->findOrFail($id);

        $teamMember->total_points = $teamMember->total_points;
        $teamMember->points_per_house_team = $teamMember->getPointsPerHouseTeam();

        return response()->json($teamMember);
    }

    public function update(Request $request, $id)
    {
        $teamMember = TeamMember::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $teamMember->update($validated);

        return response()->json($teamMember);
    }

    public function destroy($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->delete();

        return response()->json(null, 204);
    }

    public function houseTeams($id)
    {
        $teamMember = TeamMember::with('houseTeams')->findOrFail($id);
        return response()->json($teamMember->houseTeams);
    }
}

