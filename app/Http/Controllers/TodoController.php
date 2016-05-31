<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Todo;

use Validator;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function index()
    {
    	$title="Todolist by Alfi";
    	$todos = Todo::where('status','active')->get();
    	return view('index',compact('title','todos'));
    }

    public function get(Request $request,$id)
    {
    	$id = $id;
    	$todo = Todo::find($id);
    	if(empty($todo)){
    		return response()->json(['message'=>'something wrong'],404);
    	}

    	return response()->json(['message'=>'success','todo'=>$todo],200);
    }

    public function insert(Request $request)
    {
    	if(! $request->ajax()) 
    		return redirect('/');

    	$validator = Validator::make($request->all(),[
    			'name' => 'required',
    		]);
    	
    	if($validator->fails()){
    		return response()->json(['message'=>'something wrong'],400);
    	}
    	
    	$todo = new Todo;
    	$todo->name = htmlspecialchars($request->name);
    	$todo->status="active";
    	$todo->save();

    	return response()->json(['message'=>'success','todo'=>$todo],200);
    }

    public function update(Request $request){
    	if(! $request->ajax()) 
    		return redirect('/');

    	$validator = Validator::make($request->all(),[
    			'name' => 'required',
    		]);
    	
    	if($validator->fails()){
    		return response()->json(['message'=>'something wrong'],400);
    	}
    	
    	$todo = Todo::find($request->id);
		if(empty($todo))
			return response()->json(['message'=>'something wrong'],404);

    	$todo->name = htmlspecialchars($request->name);
    	$todo->status="active";
    	$todo->save();

    	return response()->json(['message'=>'success','todo'=>$todo],200);
    }
    public function done(Request $request){
    	if(! $request->ajax()) 
    		return redirect('/');

    	$todo = Todo::find($request->id);
		if(empty($todo))
			return response()->json(['message'=>'something wrong'],404);

    	$todo->status="done";
    	$todo->done_at=Carbon::now();
    	$todo->save();

    	return response()->json(['message'=>'success','todo'=>$todo],200);
    }
}
