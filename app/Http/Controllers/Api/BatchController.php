<?php

namespace App\Http\Controllers\Api;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BatchController extends Controller
{
    function __construct()
    {
        $this->middleware('jwt');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:batches,name'
        ]);
        $batch = Batch::create([
            'user_id' => $request->user,
            'name' => $request->name
        ]);
        return response()->json($batch);
    }



    public function index(Request $request)
    {
        $batches  = Batch::latest()->toBase()->paginate(10);
        return response()->json($batches);
    }
}
