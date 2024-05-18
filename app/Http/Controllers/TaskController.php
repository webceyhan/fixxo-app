<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveTaskRequest $request)
    {
        return $this->update($request, new Task());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveTaskRequest $request, Task $task)
    {
        $params = $request->validated();

        $task->fill($params)->save();

        return redirect()
            ->route('tickets.show', $task->ticket_id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tickets.show', $task->ticket_id)
            ->with('status', __('record deleted'));
    }
}
