<?php

use Mpob\Syndicates\Controllers\DashboardController;
use Mpob\Syndicates\Controllers\DocumentController;
use Mpob\Syndicates\Controllers\NetworkController;
use Mpob\Syndicates\Controllers\NoteController;
use Mpob\Syndicates\Controllers\OrgChartController;
use Mpob\Syndicates\Controllers\RelationshipController;
use Mpob\Syndicates\Controllers\SyndicateController;
use Mpob\Syndicates\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Auth::routes();
Route::group(["middleware" => "web"], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'syndicates'], function () {

        Route::get('/search', [SyndicateController::class, 'search'])->name('syndicates.search');

        Route::get('/', [SyndicateController::class, 'index'])->name('syndicates.index');
        Route::get('/create', [SyndicateController::class, 'create'])->name('syndicates.create');
        Route::get('/{syndicate}/show', [SyndicateController::class, 'show'])->name('syndicates.show');
        Route::post('/', [SyndicateController::class, 'store'])->name('syndicates.store');
        Route::get('{syndicate}/show', [SyndicateController::class, 'show'])->name('syndicates.show');
        Route::get('{syndicate}/edit', [SyndicateController::class, 'edit'])->name('syndicates.edit');
        Route::put('{syndicate}/update', [SyndicateController::class, 'update'])->name('syndicates.update');
        Route::delete('{syndicate}/archive', [SyndicateController::class, 'archive'])->name('syndicates.archive');
        Route::delete('{syndicate}/destroy', [SyndicateController::class, 'destroy'])->name('syndicates.destroy');

        Route::get('{syndicate}/networks', [NetworkController::class, 'index'])->name('networks.index');
        Route::post('{syndicate}/networks/link', [NetworkController::class, 'link'])->name('networks.link');
        Route::delete('{syndicate}/networks/unlink', [NetworkController::class, 'unlink'])->name('networks.unlink');

        Route::get('{syndicate}/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('{syndicate}/vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('{syndicate}/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
        Route::put('{syndicate}/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('{syndicate}/vehicles/destroy', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        Route::post('{syndicate}/notes/store', [NoteController::class, 'store'])->name('notes.store');
        Route::post('{syndicate}/notes/{note}/upload', [NoteController::class, 'upload'])->name('notes.upload');
        Route::delete('{syndicate}/notes/{note}/file/destroy', [NoteController::class, 'delete'])->name('notes.file.delete');

        Route::post('{syndicate}/upload/documents', [DocumentController::class, 'upload'])->name('documents.upload');
        Route::delete('{syndicate}/delete/documents', [DocumentController::class, 'delete'])->name('documents.delete');

        Route::get('orgchart', [OrgChartController::class, 'index'])->name('orgchart.index');
        Route::get('orgchart/data', [OrgChartController::class, 'getOrgChartData']);

    });

    Route::group(['prefix'=>'relationships'], function(){
       Route::get('/', [RelationshipController::class, 'index'])->name('relationships.index');
       Route::get('/create', [RelationshipController::class, 'create'])->name('relationships.create');
        Route::post('/', [RelationshipController::class, 'store'])->name('relationships.store');
        Route::get('{relationship}/edit', [RelationshipController::class, 'edit'])->name('relationships.edit');
        Route::put('{relationship}/update', [RelationshipController::class, 'update'])->name('relationships.update');
        Route::delete('{relationship}/destroy', [RelationshipController::class, 'destroy'])->name('relationships.destroy');
        Route::post('{relationship}/restore', [RelationshipController::class, 'restore'])->name('relationships.restore');
    });
});


