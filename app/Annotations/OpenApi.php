<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Task Manager API",
 *         version="1.0.0",
 *         description="REST API for managing tasks"
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000",
 *         description="Local Development Server"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */