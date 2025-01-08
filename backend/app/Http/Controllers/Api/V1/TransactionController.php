<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DataObjects\TransactionDTO;
use App\DataObjects\TransactionFilterParams;
use App\Http\Requests\V1\IndexTransactionRequest;
use App\Http\Requests\V1\StoreTransactionRequest;
use App\Http\Resources\V1\TransactionResource;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TransactionController
{
    public function __construct(protected TransactionRepository $transactionRepository) {}

    public function index(IndexTransactionRequest $request): AnonymousResourceCollection
    {
        return TransactionResource::collection(
            $this->transactionRepository->all(
                TransactionFilterParams::fromRequest($request),
            ),
        );
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $this->transactionRepository->store(TransactionDTO::fromRequest($request));

        return response()->json(
            status: 204,
        );
    }

    public function update(StoreTransactionRequest $request, Transaction $transaction): JsonResponse
    {
        $this->transactionRepository->update($transaction, TransactionDTO::fromRequest($request));

        return response()->json(
            status: 204,
        );
    }

    public function delete(Transaction $transaction): JsonResponse
    {
        $this->transactionRepository->delete($transaction);

        return response()->json(
            status: 204,
        );
    }
}
