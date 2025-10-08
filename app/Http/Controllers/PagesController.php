<?php

namespace App\Http\Controllers;


class PagesController extends Controller
{
    //
    public function index() {
        return view('pages.home',
            [
                'title' => 'Welcome to Spacelab',
                'description' => 'SpaceLab is an all-in-one academic schedule and facility management system designed to streamline school operations and enhance productivity.'
            ]
        );
    }
}
