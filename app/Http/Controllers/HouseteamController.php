<?php

namespace App\Http\Controllers;

use App\Models\Houseteam;
use Illuminate\Http\Request;

class HouseteamController extends Controller
{
    public function index(Request $request)
    {
        $houseteams = $request->user()->houseteams()
            ->with('houseteamMembers', 'pointTransactions')
            ->get()
            ->map(function ($houseteam) {
                $houseteam->total_points = $houseteam->total_points;
                return $houseteam;
            });

        return response()->json($houseteams);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $houseteam = $request->user()->houseteams()->create($validated);

        return response()->json($houseteam, 201);
    }

    public function show(Request $request, $id)
    {
        $houseteam = $request->user()->houseteams()
            ->with('houseteamMembers', 'pointTransactions')
            ->findOrFail($id);

        $houseteam->total_points = $houseteam->total_points;

        return response()->json($houseteam);
    }

    public function update(Request $request, $id)
    {
        $houseteam = $request->user()->houseteams()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $houseteam->update($validated);

        return response()->json($houseteam);
    }

    public function destroy(Request $request, $id)
    {
        $houseteam = $request->user()->houseteams()->findOrFail($id);
        $houseteam->delete();

        return response()->json(null, 204);
    }

    public function houseteamMembers($id)
    {
        $houseteam = Houseteam::with('houseteamMembers')->findOrFail($id);
        return response()->json($houseteam->houseteamMembers);
    }
}
