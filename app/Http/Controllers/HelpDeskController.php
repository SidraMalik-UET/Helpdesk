<?php

namespace App\Http\Controllers;

class HelpDeskController extends Controller
{
    public function index()
    {
        return view('helpdesk.index');
    }
}