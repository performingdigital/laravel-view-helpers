<?php

use Performing\View\Helpers\Filter;

return [
    'table' => [
        'use_filters' => true,

        'default_filters' => [
            Filter::make('Search')
                ->type('text')
                ->on(function ($query, $value) {
                    return $query->search($value);
                })
        ],

        'default_query' => [
            'per_page' => 15,
        ],

        'types' => ColumnType::class
    ]
];
