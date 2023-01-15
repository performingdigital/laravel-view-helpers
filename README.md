# Laravel View Helpers for InertiaJS
This package offers some helpers to build common data strucuture and logic in the context of CRUD applications.

## Installation

You can install the package via composer:

```bash
composer require performing/laravel-view-helpers
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-view-helpers-config"
```

This is the contents of the published config file:

```php
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
        ]
    ]
];
```

## Usage
It's basically headless so it gives you just the data in the right format to build simple tables and forms. You will need to build all the query and filter logic. 

Instead of using `Inertia::render` to return the components data we use `Performing\View\Page::class`.
```php
class PostController
{
    public function index(Request $request)
    {
        return Page::make('Posts')
            ->table(fn (Table $table) => $table
                ->rows(
                    Post::query()->latest(),
                    PostResource::class
                )
                ->columns([
                    Column::make('ID')->sortable(),
                    Column::make('Title', 'title')->sortable(),
                    Column::make('Azioni')->component(ColumnType::Actions)->sortable(),
                ])
            )->form([
                Input::make('Text'),
                Input::make('Password')->type('password'),
                Input::make('Dropdown')->type('select')->options([ 1 => 'one', 2 => 'two']),
                Input::make('Message')->type('textarea'),
            ])
            ->render('Posts/Index');
    }
}
```

## Testing

```bash
composer test
```

## Credits

- [Giorgio Pogliani](https://github.com/giorgiopogliani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
