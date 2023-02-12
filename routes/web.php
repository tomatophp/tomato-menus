<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth','splade'])->prefix('admin/menus')->name('admin.menus.')->group(function (){
    Route::get('/', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'index'])->name('index');
    Route::post('/', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'store'])->name('store');
    Route::post('/{menu}', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'update'])->name('update');
    Route::delete('/{menu}', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'destroy'])->name('destroy');

    //Items Routes
    Route::post('/{menu}/item', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'item'])->name('item');
    Route::post('/{menu}/item/all', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'itemAll'])->name('item.all');
    Route::post('/{menu}/item/pages', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'pages'])->name('item.pages');
    Route::delete('/{menu}/item/destroy', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'itemDestroy'])->name('item.destroy');
    Route::post('/{menu}/item/update', [\TomatoPHP\TomatoMenus\Http\Controllers\MenuController::class, 'itemUpdate'])->name('item.update');

});
