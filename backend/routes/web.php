<?php

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return '<img style = "width:100%"src="https://cdna.artstation.com/p/assets/images/images/034/590/744/original/sigi-daly-sonic-running-larger.gif?1612710639" />';
    // reuturn view welcome
    return Response()->view('welcome');
});
