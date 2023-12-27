<?php

namespace App\Http\Controllers;

use App\Models\tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TasksController extends Controller
{
    public function allTasks(){
        $alltasks=tasks::all();
        return response()->json($alltasks, 200);
    }

    public function createTask(Request $request){
        Validator::make($request->all(),[
            'task_name'=>'required',
            'user_id'=>'required'
        ])->validate();

        tasks::create([
            'task_name'=>$request->task_name,
            'user_id'=>$request->user_id
        ]);
        return $this->allTasks();
    }
    public function updateTask(Request $request){
        Validator::make($request->all(),[
            'edit_task'=>'required',
            'task_id'=>'required'
        ]);

        tasks::where('id',$request->task_id)->update([
            'task_name'=>$request->edit_task,
        ]);
        return $this->allTasks();
    }

    public function deleteTask(Request $request){
        tasks::where('id',$request->task_id)->delete();
       return $this->allTasks();
    }

}
