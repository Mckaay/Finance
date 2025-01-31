<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DataObjects\PotDTO;
use App\Http\Requests\V1\StorePotRequest;
use App\Http\Requests\V1\UpdatePotRequest;
use App\Http\Resources\V1\PotResource;
use App\Http\Resources\V1\ThemeResource;
use App\Models\Pot;
use App\Repositories\PotRepository;
use App\Repositories\ThemeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PotController
{
    public function __construct(protected PotRepository $potRepository) {}

    public function index(): AnonymousResourceCollection
    {
        return PotResource::collection($this->potRepository->all());
    }

    public function store(StorePotRequest $request): JsonResponse
    {
        $this->potRepository->store(PotDTO::fromRequest($request));

        return response()->json(status: 201);
    }

    public function update(UpdatePotRequest $request, Pot $pot): JsonResponse
    {
        $this->potRepository->update($pot, PotDTO::fromRequest($request));

        return response()->json(status: 204);
    }

    public function delete(Pot $pot): JsonResponse
    {
        $this->potRepository->delete($pot);

        return response()->json(status: 204);
    }

    public function getAvailableOptions(): JsonResponse
    {
        return response()->json([
            'data' => ThemeResource::collection(ThemeRepository::getAvailableThemesForPots()),
        ]);
    }
}
