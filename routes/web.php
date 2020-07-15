<?php

use Illuminate\Support\Facades\Route;
use Tanmo\Dcat\Permission\Http\Controllers;

Route::get('permission-plus', Controllers\PermissionController::class.'@index');
Route::post('permission-plus/import', Controllers\PermissionController::class.'@import')->name('permission-plus.import');
