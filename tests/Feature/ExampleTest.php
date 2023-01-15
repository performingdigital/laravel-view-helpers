<?php

use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia;
use Performing\View\Tests\FakeApp\Http\Controllers\PostController;
use Performing\View\Tests\FakeApp\Models\Post;

it('create a page', function () {
    Route::get('posts', [PostController::class, 'index'])->name('posts.index')->middleware('web');

    $posts = Post::factory(3)->create();

    $this->withoutExceptionHandling();

    $this->get(route('posts.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('title', 'Posts')
            ->has(
                'table',
                fn (AssertableInertia $table) => $table
                ->has('rows.data', 3, fn (AssertableInertia $page) => $page
                    ->where('id', 1)
                    ->where('title', $posts[0]->title)
                    ->where('created_at', $posts[0]->created_at->format('d/m/Y'))
                )
                ->has('columns', 3, fn (AssertableInertia $page) => $page
                    ->where('key', 'id')
                    ->where('title', 'ID')
                    ->where('type', 'text')
                    ->where('sortable', true)
                )
                ->has('filters')
                ->has('query')
            )
            ->has('form.schema.0', fn (AssertableInertia $page) => $page
                ->where('help', '')
                ->where('validation', '')
                ->where('type', 'text')
                ->where('label', 'Text')
                ->where('name', 'text')
                ->where('options', []))
            ->has('form.schema.1', fn (AssertableInertia $page) => $page
                ->where('help', '')
                ->where('validation', '')
                ->where('type', 'password')
                ->where('label', 'Password')
                ->where('name', 'password')
                ->where('options', []))
            ->has('form.schema.2', fn (AssertableInertia $page) => $page
                ->where('help', '')
                ->where('validation', '')
                ->where('type', 'select')
                ->where('label', 'Dropdown')
                ->where('name', 'dropdown')
                ->where('options', [1 => 'one', 2 => 'two']))
            ->has('form.data', 4));
});
