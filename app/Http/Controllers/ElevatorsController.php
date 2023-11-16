<?php

namespace App\Http\Controllers;

use App\Models\Elevator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElevatorsController extends Controller
{
    public function call()
    {
        $user = Auth::user();

        $elevator = Elevator::first();

        $elevator->floor = $user->current_floor;
        $elevator->save();

        return response()->json([
            'elevator_id' => $elevator->id,
            'floor' => $elevator->floor
        ]);
    }

    public function use(Request $request)
    {
        $user = Auth::user();
        $elevator = Elevator::where('id', $request->elevator_id)->firstOrFail();

        if ($user->current_floor != $elevator->floor) {
            return response()->json(['message' => 'you have to be in the same floor'], 403);
        }
        if (in_array($request->target_floor, $user->role->restrictedFloors())  ) {
            return response()->json(['message' => 'Restricted floor'], 403);
        }

        $user->current_floor = $request->target_floor;
        $user->save();

        $elevator->floor = $request->target_floor;
        $elevator->save();

        return response()->noContent();
    }
}
