<?php

namespace Performing\View\Tests\FakeApp\Http\Controllers;

use Illuminate\Http\Request;
use Performing\View\Helpers\Column;
use Performing\View\Helpers\ColumnType;
use Performing\View\Helpers\Input;
use Performing\View\Helpers\Table;
use Performing\View\Page;
use Performing\View\Tests\FakeApp\Http\Resources\PostResource;
use Performing\View\Tests\FakeApp\Models\Post;

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
                ]))->form([
                    Input::make('Text'),
                    Input::make('Password')->type('password'),
                    Input::make('Dropdown')->type('select')->options([1 => 'one', 2 => 'two']),
                    Input::make('Message')->type('textarea'),
                ])
            ->render('Posts/Index');
    }
}
