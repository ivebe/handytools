<?php

namespace App\Tools;

use App\Tools\Contracts\ITool;
use App\Annotations\ToolsAnnotation;
use Illuminate\Http\Request;

use Illuminate\Foundation\Inspiring;


class Word_counter implements ITool
{
    /**
     * @ToolsAnnotation(
     *     name="word_counter",
     *     serve=true,
     *     description="This is just a demo tool placeholder"
     * )
     */
    public function get(Request $request)
    {
        // TODO: If you need some data on tool initialisation use this function
    }

    public function post(Request $request)
    {
        return response()->json([
            'text' => Inspiring::quote()
        ]);
    }
}