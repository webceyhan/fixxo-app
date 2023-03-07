<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\SaveTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedParams = request()->only('search', 'status');

        $tasks = Task::query()
            ->filterByParams($allowedParams)
            ->with(['asset:id,name', 'user:id,name'])
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return inertia('Tasks/Index', [
            'tasks' => $tasks,
            'filters' => [
                'status' => TaskStatus::values(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(new Task(
            request()->only('asset_id')
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveTaskRequest $request)
    {
        return $this->update($request, new Task());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // forward to edit page
        return $this->edit($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // TODO: improve this! only for aside card representation
        $task->load('asset.customer:id,name');

        return inertia('Tasks/Edit', [
            'task' => $task,
            'statusOptions' => TaskStatus::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveTaskRequest $request, Task $task)
    {
        $params = $request->validated();

        // TODO: improve this by using a custom request
        $params['user_id'] = auth()->id();

        $task->fill($params)->save();

        return redirect()
            ->route('assets.show', $task->asset_id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('assets.show', $task->asset_id)
            ->with('status', __('record deleted'));
    }
}
