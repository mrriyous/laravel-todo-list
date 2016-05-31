<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;
use Validator;

class TodoController extends Controller
{
    public function index()
    {
    	$todos = Todo::all();
    	$title = "Todo list by ALFI SYAHRI";
    	return view('index',compact('todos','title'));
    }

    public function get(Request $request,$id)
    {
    	if(empty($id)) return response()->json(['message'=>'Somethings wrong'],400);

    	$todo = Todo::find($id);
    	if(empty($todo)) return response()->json(['message'=>'item not found'],404);

    	return response()->json(['message'=>'success','todo'=>$todo],200);

    }

    public function insert(Request $request)
    {
    	if(! $request->ajax()) return redirect('/');

    	$validator = Validator::make($request->all(),[
    		'todo'=> 'required',
    	]);

    	if($validator->fails())
    	{
    		return response()->json(['message' => 'Somethings wrong'],400);
    	}

    	$todo = new Todo;
    	$todo->name = htmlspecialchars($request->input('todo'));
    	$todo->status = 'active';
    	$todo->save();
    	return response()->json(['message'=>'success','todo'=>$todo],200);
    }
}
