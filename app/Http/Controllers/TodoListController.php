<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todoLists = TodoList::all();
        return view('todolist.index', compact('todoLists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new TodoList();
        $task->content = $request->content;
        $task->status = 'In progress';
        $task->save();
        return back();
    }

    public function update($id)
    {
        $task = TodoList::find($id);
        $task->status = 'Completed';
        $task->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = TodoList::find($id);
        $task->delete();
        return back();
    }
}
