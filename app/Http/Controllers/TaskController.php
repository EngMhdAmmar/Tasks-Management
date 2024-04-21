<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Enums\Priority;
use App\Enums\TaskStatus;
use App\Jobs\SendDeadLine;
use App\Enums\ScheduleType;
use App\Jobs\SendAssignment;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\tasks\StoreRequest;
use App\Http\Requests\tasks\UpdateRequest;

class TaskController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $tasks = Task::where('leader_id', $user->id)
            ->orderBy('priority', 'desc')
            ->paginate(15);
        $users = User::orderBy('name')->get();
        session()->remove('user');
        return view('tasks.index', compact('tasks', 'users'));
    }

    public function userTasks()
    {
        $page = request()->query('page');
        $user = auth()->user();
        // This Is how to use cache but i sow it is'nt a practical way
        // $tasks = Cache::remember("my_tasks_page_$page", now()->addHour(), fn () => Task::with('leader')->where('user_id', $user->id)
        //     ->orderBy('priority', 'desc')
        //     ->paginate(15));
        $tasks = Task::with('leader')->where('user_id', $user->id)
                ->orderBy('priority', 'desc')
                ->paginate(15);
        return view('tasks.user_tasks', compact('tasks'));
    }

    public function store(StoreRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $data['priority'] = Priority::matchEnum($request->priority);
        $data['schedule'] = ScheduleType::matchEnum($request->schedule);
        $data['leader_id'] = $user->id;
        $task = Task::create($data);
        $delayInSeconds = strtotime($task->dead_line) - time();
        SendDeadLine::dispatch($task->id)->delay($delayInSeconds);
        SendAssignment::dispatch($task->id);
        return redirect()->route('tasks.index');
    }

    public function update(UpdateRequest $request, string $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->validated();
        $data['priority'] = Priority::matchEnum($request->priority);
        $data['schedule'] = ScheduleType::matchEnum($request->schedule);
        if ($task->user_id != $data['user_id']) SendAssignment::dispatch($task->id);
        $task->update($data);
        return redirect()->route('tasks.index');
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function approveAndComplete(String $id)
    {
        $task = Task::findOrFail($id);
        if ($task->status == TaskStatus::Done) return;
        if ($task->status == TaskStatus::To_Do) $task->status = 1;
        else if ($task->status == TaskStatus::In_Progress) $task->status = 2;
        $task->save();
        return redirect()->route('tasks.user');
    }

    public function all()
    {
        $tasks = Task::orderBy('priority', 'desc')
            ->paginate(15);
        return view('tasks.all_tasks', compact('tasks'));
    }
}
