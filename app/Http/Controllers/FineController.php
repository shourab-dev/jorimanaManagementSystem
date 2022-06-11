<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Batch;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class FineController extends Controller
{
    function __construct()
    {
        $this->middleware('jwt');
    }
    public function store(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();
        foreach ($request->forms as $form) {

            Fine::create([
                'user_id' => $user->id,
                'batch_id' => $request->batchId,
                'name' => $form['name'],
                'amount' => $form['amount'],
                'ispaid' => $form['paid'],
            ]);
        }
        return response()->json(200);
    }
    public function batchesFine(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return Batch::with(['fines' => function ($q) {
            $q->where('ispaid', 1)->sum('amount');
        }])->where('user_id', $user->id)->get();
    }
}
