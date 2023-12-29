<?php

namespace App\Http\Controllers;

use App\Models\tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TasksController extends Controller
{
    public function allTasks(Request $request){
        $alltasks=tasks::where('user_id',$request->user_id)->get();
        return response()->json($alltasks, 200);
    }

    //သက်ဆိုင်တဲ့ user ရဲ့ task တွေကိုပဲခေါ်မှာ
    private function tasks($userid){
        $usertasks=tasks::where('user_id',$userid)->get();
        return response()->json($usertasks, 200);
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
        return $this->tasks($request->user_id);
    }
    public function updateTask(Request $request){
        Validator::make($request->all(),[
            'edit_task'=>'required',
            'task_id'=>'required'
        ]);

        tasks::where('id',$request->task_id)->update([
            'task_name'=>$request->edit_task,
        ]);
        return $this->tasks($request->user_id);
    }

    public function deleteTask(Request $request){
        tasks::where('id',$request->task_id)->delete();
        return $this->tasks($request->user_id);
    }
    public function addFav(Request $request){

            tasks::where('id',$request->task_id)
            ->update([
                'isFav'=>$request->isFav,
            ]);
            return $this->tasks($request->user_id);
    }
    public function addDone(Request $request){

        tasks::where('id',$request->task_id)
        ->update([
            'isDone'=>$request->isDone,
        ]);
        return $this->tasks($request->user_id);
}

}
