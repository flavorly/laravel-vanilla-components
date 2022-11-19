<?php

namespace Flavorly\VanillaComponents\Datatables\Data;

use Flavorly\VanillaComponents\DataCasts\ArrayToCollection;
use Flavorly\VanillaComponents\Datatables\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as ModelsCollection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;

class DatatableRequest extends Data
{
    public function __construct(

        public string|null $search,

        public int $perPage,

        #[MapInputName('selected')]
        #[WithCast(ArrayToCollection::class)]
        public Collection $selectedRowsIds,

        #[MapInputName('selectedAll')]
        public bool $isAllSelected,

        #[WithCast(ArrayToCollection::class)]
        public Collection $filters,

        #[WithCast(ArrayToCollection::class)]
        public Collection $sorting,

        #[MapInputName('action')]
        public string|null $actionName,

        public Optional|Action $action,

        public Optional|Builder|ScoutBuilder|null $query,

        public Optional|ModelsCollection $selectedModels,
    ) {
    }

    public static function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable', 'integer'],
            'selected' => ['nullable', 'array'],
            'selectedAll' => ['required', 'boolean'],
            'filters' => ['nullable', 'array'],
            'sorting' => ['nullable', 'array'],
            'action' => ['nullable', 'string'],
            'query' => ['nullable'],
        ];
    }
}
