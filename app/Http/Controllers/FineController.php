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
        return Batch::select('id', 'name', 'status')->withSum(['fines as collectFines' => function ($q) {
            $q->where('ispaid', true);
        }], 'amount')->withSum('fines as totalFines', 'amount')->where('status', true)->where('user_id', $user->id)->latest()->paginate(5);
    }



    public function batchWiseFine(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $batchId = $request->header('id');
        $allName = Fine::where('user_id', $user->id)->where('batch_id', $batchId)->select('name', 'batch_id')->distinct()->get()->toArray();
        $batch = Batch::find($batchId, ['id', 'name']);
        // $fineList = Fine::where('user_id', $user->id)->where('batch_id', $batchId)->get()->groupBy('name');
        return response()->json(['batch' => $batch, 'list' => $allName]);
    }


    public function studentFine(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $fine =  Fine::where('user_id', $user->id)->where('batch_id', $request->batchId)->where('name', $request->name)->select('id', 'amount', 'ispaid')->get();
        return response()->json($fine);
    }

    public function fineUpdate(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $id =  $request->fineId;
        $fine = Fine::find($id);
        if ($fine->ispaid == 1) {
            $fine->ispaid = 0;
        } else {
            $fine->ispaid = 1;
        }
        $fine->save();
        return response()->json($fine);
    }
}
