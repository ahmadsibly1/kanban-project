<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class TaskController extends Controller
{
    private $tasks;

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Task List';
        $tasks = Task::all();
        return view('tasks.index', [
            'pageTitle' => $pageTitle,
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Task Create';
        $status = 'progress';
        return view('tasks.create', [
            'pageTitle' => $pageTitle,
            'status' => $status,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // code untuk validasi
        $request->validate(
            [
                'name' => 'required',
                'due_date' => 'required',
                'status' => 'required',
            ],
            $request->all()
        );

        // proses memasukan data ke database
        Task::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Task';
        $task = Task::find($id);

        return view('tasks.edit', [
            'pageTitle' => $pageTitle,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        $task->update([
            'name' => $request->name,
            'detail' => $request->detail,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index');
    }

    // buatan sendiri
    public function delete(string $id)
    {
        $pageTitle = 'Delete Task';
        $task = Task::find($id);

        return view('tasks.delete', [
            'pageTitle' => $pageTitle,
            'task' => $task,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect()->route('tasks.index');
    }

    // Task Progress
    public function progress()
    {
        $title = 'Task Progress';

        $tasks = Task::all();
        $filteredTasks = $tasks->groupBy('status');

        $tasks = [
            'not_started' => $filteredTasks->get('not_started', []),
            'in_progress' => $filteredTasks->get('in_progress', []),
            'completed' => $filteredTasks->get('completed', []),
            'in_review' => $filteredTasks->get('in_review', []),
        ];
        // dd($tasks);
        return view('tasks.progress', [
            'pageTitle' => $title,
            'tasks' => $tasks,
        ]);
    }

    // Move 
    public function move(int $id, Request $request)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.progress');
    }
}
