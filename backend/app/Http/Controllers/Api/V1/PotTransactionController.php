<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DataObjects\PotTransactionDTO;
use App\Http\Requests\V1\StorePotTransactionRequest;
use App\Models\PotTransaction;
use DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class PotTransactionController
{
    public function store(StorePotTransactionRequest $request)
    {
        $potTransactionDTO = PotTransactionDTO::fromRequest($request);

        try {
            DB::transaction(function () use ($potTransactionDTO): void {
                PotTransaction::create($potTransactionDTO->toArray());
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }

        return response()->json(status: 201);
    }
}
