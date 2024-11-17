<?php

namespace App\Http\Controllers;

use App\Models\HouseteamMember;
use Illuminate\Http\Request;

class HouseteamMemberController extends Controller
{
    public function index(Request $request)
    {
        $houseteamMembers = $request->user()->houseteamMembers()
            ->with('houseteams', 'pointTransactions')
            ->get()
            ->map(function ($member) {
                $member->total_points = $member->total_points;
                return $member;
            });

        return response()->json($houseteamMembers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $houseteamMember = $request->user()->houseteamMembers()->create($validated);

        return response()->json($houseteamMember, 201);
    }

    public function show(Request $request, $id)
    {
        $houseteamMember = $request->user()->houseteamMembers()
            ->with('houseteams', 'pointTransactions')
            ->findOrFail($id);

        $houseteamMember->total_points = $houseteamMember->total_points;

        return response()->json($houseteamMember);
    }

    public function update(Request $request, $id)
    {
        $houseteamMember = $request->user()->houseteamMembers()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $houseteamMember->update($validated);

        return response()->json($houseteamMember);
    }

    public function destroy(Request $request, $id)
    {
        $houseteamMember = $request->user()->houseteamMembers()->findOrFail($id);
        $houseteamMember->delete();

        return response()->json(null, 204);
    }

    public function houseteams($id)
    {
        $houseteamMember = HouseteamMember::with('houseteams')->findOrFail($id);
        return response()->json($houseteamMember->houseteams);
    }
}
