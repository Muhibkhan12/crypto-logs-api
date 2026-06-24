<?php

namespace App\Http\Controllers;

use App\Models\AddTrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TradeExecutionController extends Controller
{
    public function addTrade(Request $request){
        $validated = Validator::make($request->all(),[
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

        $data = AddTrade::create([
        'user_id' => Auth::id(), // JWT token se user id
        'coin' => $request->coin,
        'type' => $request->type,
        'entry_price' => $request->entry_price,
        'quantity' => $request->quantity,
        'status' => $request->status,
        'opened_at' => $request->opened_at,
        'closed_at' => $request->closed_at,
    ]);


        return response()->json([
            'status'=> true,
            'message'=> 'Validation successfull',
            'data' => $data,
        ],200);

    }

    public function updateUserTrade(Request $request, $id){
        $data = addTrade::findorFail($id);
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

        $data->update($validated);

        return response()->json([
            'status' => True,
            'message' => 'Trade Updated Successfully',
            'data '=> $data,
        ],200);
    }
    public function deleteTrade(Request $request, $id){
        $data = AddTrade::where('id',$id)->where('user_id',Auth::id())->first();

        if(!$data){
            return response()->json([
                'status' => false,
                'message'=> 'Trade doesnt exist',
            ],404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully',
        ],200);
    }
}
