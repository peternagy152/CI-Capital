<?php

namespace App\Http\Responses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MyJsonResponse implements Responsable
{
    public function __construct(
        public readonly array $data,
        public readonly int $status = Response::HTTP_OK
    ) {}

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            $this->data,
            $this->status
        );
    }
}
