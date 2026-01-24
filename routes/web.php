<?php

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): Factory|View => view('welcome'));

Route::get('/docs/api', fn (): Factory|View => view('docs.api'))->name('docs.api');
