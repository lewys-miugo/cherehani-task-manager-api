<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
    ) {}

    public function index()
    {
        //
        return TaskResource::collection(
            $this->taskRepository->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        //
        $task = $this->taskRepository->create(
            $request->validated()
        );

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
        return new TaskResource(
            $this->taskRepository->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, int $id)
    {
        //
        $task = $this->taskRepository->update(
            $id,
            $request->validated()
        );

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        //
        $this->taskRepository->delete($id);

        return response()->json(null, 204);
    }
}
