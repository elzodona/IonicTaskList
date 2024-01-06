<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Database\QueryException;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Controllers\RequestMessages;

class TaskController extends Controller
{
    private $message;

    public function __construct() {
        $this->message = new RequestMessages();
    }

    public function compareId($id)
    {
        if (auth()->user()->id == $id) {
            return true;
        }
        return false;
    }

    public function index($idUser)
    {
        if ($this->compareId($idUser)) {
            $tasks = Task::where('user_id', $idUser)->get();
            return $this->message->succedRequest($tasks, 'liste des taches', 200);
        }else{
            return $this->message->errorRequest('Unauthenticated', 500);
        }

    }


    public function searchTask(Request $request, $idUser)
    {
        if ($this->compareId($idUser)) {
            $name = $request->taskName;
            if(strlen($name) > 0){
                $result = Task::where('user_id', $idUser)
                                ->where('taskName','like','%'.$name.'%')
                                ->get();
                if (count($result) > 0){
                    return  $this->message->succedRequest($result, 'Tasks found', 200);
                }else{
                    return $this->message->errorRequest('Aucune tache enregistrée', 404);
                }
            }
        } else {
            return $this->message->errorRequest('Unauthenticated', 500);
        }
    }

    public function store(Request $request, $idUser)
    {
        if ($this->compareId($idUser)) {
            try{
                $task = Task::create([
                    "taskName" => $request->taskName,
                    "taskDate" => $request->taskDate,
                    "category" => $request->category,
                    "priority" => $request->priority,
                    "user_id" => $idUser
                ]);
                return $this->message->succedRequest($task,"Task added successfully!",201);

            }catch(QueryException $e){
                if($e->getCode() == '23000');
                return $this->message->errorRequest("Adding Error!",404);
            }
        } else {
            return $this->message->errorRequest('Unauthenticated', 500);
        }

    }

    public function update(Request $request,$idUser)
    {
        if ($this->compareId($idUser)) {
            try{
                $task = Task::where('id',$request->id)
                            ->where('user_id',$idUser)->first();

                $task->update([
                    'taskName'=> $request->taskName ?? $task->taskName,
                    'taskDate'=> $request->taskDate ?? $task->taskDate,
                    'category'=>$request->category ?? $task->category,
                    'priority' => $request->priority ?? $task->priority,
                ]);

                return $this->message->succedRequest($task,'Updated with success !',200);

            }catch(QueryException $e){
                if($e->getCode() == '23000');
                return $this->message->errorRequest("Editing Error!",404);
            }
        } else {
            return $this->message->errorRequest('Unauthenticated', 500);
        }
    }

    public function destroy($idUser,$idTask)
    {
        if ($this->compareId($idUser)) {
            try {
                $deleteTask = Task::where('user_id',$idUser)
                            ->where('id',$idTask)->first();

                if($deleteTask){
                    $title = $deleteTask->taskName;
                    $deleteTask->delete();
                    return $this->message->succedRequest($title,"deleted succussfully!", 200);
                }else{
                    return $this->message->errorRequest("Task not found or could not be deleted!", 404);
                }

            } catch(QueryException $e){
                if($e->getCode() == '23000');
                return $this->message->errorRequest("Processing Error !",500);
            }
        } else {
            return $this->message->errorRequest('Unauthenticated', 500);
        }

    }

}
