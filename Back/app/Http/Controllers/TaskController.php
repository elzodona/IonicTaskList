<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
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
    public function index()
    {
        //
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
                    "etat"=>"not_done",
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
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
