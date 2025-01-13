<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\PotDTO;
use App\Enums\PotTransactionType;
use App\Models\Pot;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

final class PotRepository implements PotRepositoryInterface
{
    public function all(): Collection
    {
        return Pot::query()
            ->select('pots.*')
            ->withSum([
                'pottransactions as depositSum' => fn($query) => $query->where('type', PotTransactionType::DEPOSIT->value),
                'pottransactions as withdrawSum' => fn($query) => $query->where('type', PotTransactionType::WITHDRAW->value),
            ], 'amount')
            ->with('theme')
            ->get();
    }

    public function store(PotDTO $potDTO): bool
    {
        try {
            DB::transaction(function () use ($potDTO): bool {
                Pot::create([
                    'user_id' => auth()->id(),
                    ...$potDTO->toArray(),
                ]);

                return true;
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }

        return false;
    }

    public function update(Pot $pot, PotDTO $potDTO): bool
    {
        return $pot->updateOrFail($potDTO->toArray());
    }

    public function delete(Pot $pot): bool
    {
        return $pot->deleteOrFail();
    }

    public function find(int $id): Pot
    {
        return Pot::findOrFail($id);
    }
}
