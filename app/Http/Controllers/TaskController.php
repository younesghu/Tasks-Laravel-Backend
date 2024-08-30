<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api')->except(['store']);
    // }
    public function create(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Validate the request data
        $data = $request->validate([
            'title' => 'required|unique:tasks,title',
            'description' => 'required',
        ]);

        try {
            // Attach the authenticated user to the task data
            $data['user_id'] = $user->id;

            // Create the task
            $task = Task::create($data);

            // Return a success response with the created task
            return response()->json([
                'message' => 'Task created successfully!',
                'task' => new TaskResource($task),
            ], 201); // 201: Resource created successfully

        } catch (\Exception $e) {
            // Return an error response if task creation fails
            return response()->json([
                'message' => 'Task failed to be created!',
                'error' => $e->getMessage(),
            ], 500); // 500: Internal server error
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $tasks = $user->tasks()->orderBy('updated_at', 'desc')->get();
        return TaskResource::collection($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function store(Request $request)
    // {
    //     $result = Task::create($request->validated());

    //     return new TaskResource($result);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Task $task, Request $request)
    {
        $user = $request->user();

        // Check if the authenticated user owns the task
        if ($user->id !== $task->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Task $task, Request $request)
    {
        $user = $request->user();

        // Ensure the authenticated user owns the task
        if ($user->id !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        // Toggle the task status
        $newStatus = $task->status === 'complete' ? 'incomplete' : 'complete';

        // Update the task status
        $task->update(['status' => $newStatus]);
        $task->save();

        // Return the updated task as a resource
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Request $request)
    {
        $user = $request->user();
        if( $user->id !== $task->user_id ) {
            return abort(433, 'Unauthorized action.');
        }

        $task->delete();

        return response()->json(['message' => 'Task has been deleted successfully!'], 200);
    }
}
