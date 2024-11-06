<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function index():String
    {
        $data = ['title' => 'Home'];
        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('estructura/main')
            .view('estructura/footer');
    }

}
