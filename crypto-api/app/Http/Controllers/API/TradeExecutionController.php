<?php

namespace App\Http\Controllers;

use App\Models\AddTrade;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TradeExecutionController extends Controller
{
    public function addTrade(Request $request){
        $validated = Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'coin' => 'required|string',
            'type' => 'required|in:buy,sell',
            'entry_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'status' => 'required|in:open,closed',
            'opened_at' => 'nullable|date',
            'closed_at' => 'nullable|date',

        ]);

        if($validated->fails()){
            return response()->json([
                'status'=> false,
                'message' => 'Validation failed',
                'error' => $validated->errors(),
            ],422);
        }

        $data = AddTrade::create($validated);
        return response()->json([
            'status'=> true,
            'message'=> 'Validation successfull',
            'data' => $data,
        ],200);

    }
}
