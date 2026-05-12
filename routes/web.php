<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Marketing routes (audania.de)
|--------------------------------------------------------------------------
|
| Per parent monorepo CLAUDE.md §9 (2026-05-09 marketing-as-route-group
| decision), marketing pages live in this Laravel app as a Blade route
| group with their own layout — no Livewire — alongside the Praxis-facing
| UI. Re-split triggers are documented in root §9.
*/

Route::view('/', 'marketing.home')->name('marketing.home');
Route::view('/wie-audania-denkt', 'marketing.journeys')->name('marketing.journeys');
Route::view('/impressum', 'marketing.impressum')->name('marketing.impressum');
Route::view('/datenschutz', 'marketing.datenschutz')->name('marketing.datenschutz');
