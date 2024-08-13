<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all existing tasks in Database and return them as JSON
        $tasks = Task::all();
        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|unique:tasks,title',
            'description' => 'required',
        ]);

        try {
            // Create the task
            $task = Task::create($data);
            // Return a success response with the created task
            return response()->json([
                'message' => 'Task created successfully!',
                'task' => $task,
            ], 201); // 201: Resource created successfully

        } catch (\Exception $e) {
            // Return an error response if task creation fails
            return response()->json([
                'message' => 'Task failed to be created!',
                'error' => $e->getMessage()
            ], 500); // 500: Internal server error
        }
    }
    public function complete(string $taskId)
    {
        // Find the task by ID
        $task = Task::find($taskId);

        // Return an error if the task is not found
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Update the task status to completed
        $task->update(['status' => 'complete']);

        // Return a success response with the updated task
        return response()->json([
            'message' => 'Task marked as completed!',
            'task' => $task
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $taskId)
    {
        // Find the task by ID
        $task = Task::find($taskId);

        // Return an error if the task is not found
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Return the found task
        return response()->json([
            'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $taskId)
    {
        // Find the task by ID
        $task = Task::find($taskId);

        // Return an error if the task is not found
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Delete the task
        $task->delete();

        // Return a success response indicating deletion
        return response()->json([
            'message' => 'Task has been deleted successfully!',
        ]);
    }
}
