<?php

namespace Flavorly\VanillaComponents\Core\Components\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class ResolveRichSelectOptions
{
    public function __construct(
        protected string $model,
        protected array $columns = [],
        protected bool $useScout = true,
        protected int $perPage = 10,
    ) {
    }

    /**
     * Builds the query and returns the paginator
     */
    public function response(): LengthAwarePaginator
    {
        // Store the values
        $searchQuery = request()->query('query');
        $values = request()->query('values');
        $page = request()->query('page', 1);

        /** @var Model|Builder $model */
        $model = app($this->model);
        $scoutKeys = []; // Stores Laravel scout temporary keys

        // If none is filled, return teh latest paginated results
        if (! filled($searchQuery) && ! filled($values)) {
            return $model::query()->latest()->paginate($this->perPage);
        }

        if ($this->useScout && in_array(Searchable::class, class_uses($model::class))) {
            /** @var Searchable $model */
            $scoutKeys = $model::search($searchQuery ?? '')->keys() ?? [];
        }

        return $model::query()
            // If we have values, then we can instantly filter them here
            ->when(filled($values), function ($query) use ($model, $values) {
                $query->whereIn($model->getKeyName(), ! is_array($values) ? Str::of($values)->explode(',') : $values);
            })
            // Not using scout and using regular search
            ->when(! $this->useScout && filled($searchQuery) && ! empty($this->columns), function ($query) use ($searchQuery) {
                $query->where(function ($query) use ($searchQuery) {
                    foreach ($this->columns as $column) {
                        $query->orWhere($column, 'like', "%{$searchQuery}%");
                    }
                });
            })
            // Using Scout
            ->when($this->useScout && filled($searchQuery) && ! empty($scoutKeys), function ($query) use ($model, $scoutKeys) {
                $query->whereIn($model->getKeyName(), $scoutKeys);
            })
            // Finally paginate the results
            ->paginate(perPage: $this->perPage, page: $page);
    }

    /**
     * Resolves the current select options for a given model and given columns
     * Supporting scout searching
     * This function is intended to be used for frontend pooling with Rich Select
     *
     * @throws \Exception
     */
    public static function for(string $model, array $columns = [], bool $useScout = true): LengthAwarePaginator
    {
        return (new static($model, $columns, $useScout))->response();
    }
}
