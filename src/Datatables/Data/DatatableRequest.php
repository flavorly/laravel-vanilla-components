<?php

namespace Flavorly\VanillaComponents\Datatables\Data;

use Flavorly\VanillaComponents\DataCasts\ArrayToCollection;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class DatatableRequest extends Data
{
    public function __construct(

        public string|null $search,
        public int $perPage,

        #[MapInputName('selected')]
        #[WithCast(ArrayToCollection::class)]
        public Collection $selectedRows,

        public bool $selectedAll,

        #[WithCast(ArrayToCollection::class)]
        public Collection $filters,

        #[WithCast(ArrayToCollection::class)]
        public Collection $sorting,

        public string|null $action,
    ) {
    }

    public static function rules(): array
    {
        return [
            'search' => ['nullable','string'],
            'perPage' => ['nullable', 'integer'],
            'selected' => ['nullable', 'array'],
            'selectedAll' => ['required', 'boolean'],
            'filters' => ['nullable', 'array'],
            'sorting' => ['nullable', 'array'],
            'action' => ['nullable', 'string'],
        ];
    }
}
