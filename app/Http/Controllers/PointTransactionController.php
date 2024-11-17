<?php

namespace App\Http\Controllers;

use App\Models\PointTransaction;
use Illuminate\Http\Request;

class PointTransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'points' => 'required|integer',
            'reason' => 'nullable|string',
            'houseteam_member_id' => 'required|exists:houseteam_members,id',
            'houseteam_id' => 'required|exists:houseteams,id',
        ]);

        $pointTransaction = PointTransaction::create($validated);

        return response()->json($pointTransaction, 201);
    }
}
