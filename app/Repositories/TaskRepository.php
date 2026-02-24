<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        $query = Task::query();

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        if (request()->boolean('overdue')) {
            $query->whereDate('due_date', '<', now())
                ->where('status', 'pending');
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id)
    {
        return Task::findOrFail($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(int $id, array $data)
    {
        $task = $this->find($id);
        $task->update($data);
        return $task;
    }

    public function delete(int $id)
    {
        $task = $this->find($id);
        $task->delete();
    }
}