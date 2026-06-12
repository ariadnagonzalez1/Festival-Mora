<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Public\Home\HomePage;

Route::get('/', HomePage::class)->name('public.inicio');

Route::view('/eventos', 'public.placeholder')->name('public.eventos');
Route::view('/experiencias-mora', 'public.placeholder')->name('public.experiencias');