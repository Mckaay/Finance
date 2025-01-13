<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\PotDTO;
use App\Models\Pot;
use Illuminate\Support\Collection;

interface PotRepositoryInterface
{
    public function all(): Collection;
    public function store(PotDTO $potDTO): bool;
    public function update(Pot $pot, PotDTO $potDTO): bool;
    public function delete(Pot $pot): bool;
    public function find(int $id): Pot;
}
