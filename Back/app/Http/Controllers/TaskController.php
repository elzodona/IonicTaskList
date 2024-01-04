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

   
    /**
     * Display a listing of the resource.
     */
    public function index($idUser)
    {
        $tasks = Task::where('user_id',$idUser)->get(); 
        return $this->message->succedRequest($tasks,'liste des taches',200);
    }


    public function searchTask(Request $request, $idUser)
    {   
        $title = $request->title;
        if(strlen($title)>=3){
            $result = Task::where('user_id', $idUser)
                            ->where('title','like','%'.$title.'%')
                            ->get();
            return  $this->message->succedRequest($result,'Tasks found',200);
        }
        
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idUser)
    {
        try{
                $task = Task::create([
                    "title" => $request->title,
                    "description"=>$request->description,
                    "user_id"=>$idUser
                ]);
                return $this->message->succedRequest($task,"Task added successfully!",201);  

            }catch(QueryException $e){
            if($e->getCode() == '23000');    
            return $this->message->errorRequest("Adding Error!",404);           
        } 
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$idUser)
    {
       try{

            $task  = Task::where('id',$request->id)
                        ->where('user_id',$idUser)->first();

                        $task->update([
                            'title'=> $request->title ?? $task->title,
                            'description'=> $request->description ?? $task->description,
                            'etat'=>$request->etat ?? $task->etat
                        ]);
            return $this->message->succedRequest($task,'Updated with success !',200);
        }catch(QueryException $e){
            if($e->getCode() == '23000');    
            return $this->message->errorRequest("Editing Error!",404);           
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idUser,$idTask)
    {
        try {
                $deleteTask = Task::where('user_id',$idUser)
                            ->where('id',$idTask)->first();
                                 
                    if($deleteTask){
                        $title = $deleteTask->title;
                        $deleteTask->delete();
                        return $this->message->succedRequest($title,"deleted succussfully!", 200);
                    }else{
                        return $this->message->errorRequest("Task not found or could not be deleted!", 404);
                    }
        } catch(QueryException $e){
            if($e->getCode() == '23000');    
            return $this->message->errorRequest("Processing Error !",500);           
        } 
        
    }
}
