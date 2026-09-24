<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', function () {
    return view('Menu');
});

Route::get('/contacto', function () {
    return view('contacto');
});

Route::get('/reservas', function () {
    return view('reservas');
});
