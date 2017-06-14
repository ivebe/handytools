<?php

namespace App;

interface IParser
{
    public function getTools();
    public function compileVueRoutes();
}