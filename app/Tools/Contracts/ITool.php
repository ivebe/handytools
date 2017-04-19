<?php

namespace App\Tools\Contracts;

use Illuminate\Http\Request;

interface ITool
{
    public function get( Request $request );
    public function post( Request $request );
}