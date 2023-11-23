<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\ToDoList;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $lists = ToDoList::get();
        return view('todo', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required','max:255'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }
        //
        $data = [
            'title' => $request->title,
            'is_completed' => !empty($request->status) ? $request->status : 0
        ];
        if(empty($request->todo_id)){
            $query = ToDoList::create($data);
            $msg = "New task added successfully.";
        } else {
            $query = ToDoList::updateOrCreate([ 'id' => $request->todo_id ], $data);
            $msg = "Todo list updated successfully.";
        }
        if($query){
            $res = ['status' => true, 'msg' => $msg];
        }else {
            $res = ['status' => false, 'msg' => 'Failed'];
        }
        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $is_complete = 0;
        if(!empty($_GET['is_complete'])){
            $is_complete = 1;
        }
        $query = ToDoList::updateOrCreate([ 'id' => $_GET['id'] ], ['is_completed' => $is_complete]);
        if($query){
            $res = ['status' => true, 'msg' => "Task has been completed."];
        }else {
            $res = ['status' => false, 'msg' => 'Failed'];
        }
        return response()->json($res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        try { 
            ToDoList::where('id', $request->todo_id)->delete();
            return response()->json(['status'=>true, 'msg' => 'Deleted Successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'msg' => 'Something went wrong !']);
        }   
    }
}
