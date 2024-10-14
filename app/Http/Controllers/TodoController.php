<?php

namespace App\Http\Controllers;

use App\Models\todo;
use Illuminate\Http\Request;

class todoController extends Controller
{
    public function index()
    {
        $data = Todo::all();
        //dd($data);
        return view('todos.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|min:3|max:30',
        ],[
            'task.required' => 'Enter a task again',
            'task.min' => 'Enter minimum of 3 character',
            'task.max' => 'Hold up!',
        ]);

        Todo::create([
            'task' => $request->task,
        ]);

        return redirect()->route('todos.index')->with('success', 'Task added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required|min:3|max:30',
            'is_done' => 'required|boolean',
        ],[
            'task.required' => 'Enter a task again',
            'task.min' => 'Enter minimum of 3 character',
            'task.max' => 'Hold up!',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update([
            'task' => $request->task,
            'is_done' => $request->is_done,
        ]);

        return redirect()->route('todos.index')->with('success', 'Task updated successfully!');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete(); //softdeletes

        return redirect()->route('todos.index')->with('success', 'Task deleted successfully!');
    }
}
