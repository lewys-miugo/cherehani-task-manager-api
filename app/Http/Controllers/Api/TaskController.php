<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="Task Management Endpoints"
 * )
 */
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="List all tasks",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by task status (pending or completed)",
     *         required=false,
     *         @OA\Schema(type="string", example="pending")
     *     ),
     *     @OA\Parameter(
     *         name="overdue",
     *         in="query",
     *         description="Filter overdue pending tasks",
     *         required=false,
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of tasks"
     *     )
     * )
     */

    public function index()
    {
        //
        return TaskResource::collection(
            $this->taskRepository->all()
        );
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create a new task",
     *     tags={"Tasks"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","due_date"},
     *             @OA\Property(property="title", type="string", example="Finish API project"),
     *             @OA\Property(property="description", type="string", example="Complete OpenAPI documentation"),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2026-03-10")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Task created successfully"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
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
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Get a single task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=200, description="Task details"),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function show(int $id)
    {
        //
        return new TaskResource(
            $this->taskRepository->find($id)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Update a task",
     *     tags={"Tasks"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated title"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(property="status", type="string", example="completed"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2026-03-15")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Task updated successfully"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=404, description="Task not found")
     * )
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
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Delete a task",
     *     tags={"Tasks"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=204, description="Task deleted successfully"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        //
        $this->taskRepository->delete($id);

        return response()->json(null, 204);
    }
}
