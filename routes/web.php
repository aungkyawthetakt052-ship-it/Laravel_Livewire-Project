<?php

use Illuminate\Support\Facades\Route;



Route::livewire('users','pages::users.index')->name('users.index');
Route::livewire('users/create','pages::users.create')->name('users.create');
Route::livewire('users/edit{user}','pages::users.edit')->name('users.edit');
Route::livewire('users/{id}','pages::users.delete')->name('users.delete');
