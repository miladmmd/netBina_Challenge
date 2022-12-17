<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;

    /**
     * @param array $payload
     * @return Model|null
     */

    public function create(array $payload): ?Model;

    /**
     * @param int $modelId
     * @param array $payload
     * @return bool
     */

    public function update(int $modelId,array $payload): bool;

    /**
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool;
}
