<?php

namespace App\Http\Controllers\Api;

use App\Models\Batch;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class BatchController extends Controller
{
    function __construct()
    {
        $this->middleware('jwt');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:batches,name,user_id'
        ]);
        $batch = Batch::create([
            'user_id' => $request->user,
            'name' => $request->name
        ]);
        return response()->json($batch);
    }



    public function index(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $batches  = Batch::where('user_id', $user->id)->latest()->toBase()->paginate(10);
        return response()->json($batches);
    }
    public function update(Request $request)
    {
        $request->validate([
            'value.name' => 'required|unique:batches,name'
        ]);
        
        $batch = Batch::find($request->value['id']);
        $batch->name = $request->value['name'];
        $batch->save();

        return response()->json($batch);
    }

    public function destroy(Request $request)
    {
        $id =  $request->header('id');
        Batch::find($id)->delete();
    }
}
