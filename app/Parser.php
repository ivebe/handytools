<?php

namespace App;

use App\Annotations\ToolsAnnotation;
use Illuminate\Support\Facades\Cache;

class Parser implements IParser
{
    public function getTools()
    {
        if (Cache::has('parser_tools_list')) {
            return Cache::get('parser_tools_list');
        }

        $methods = [];
        $reflections['tools'] = new \ReflectionClass(Tools::class);

        foreach($this->getToolsByInterface() as $tool)
        {
            $route = strtolower( str_replace('\\App\\Tools\\', '', $tool) );
            $route = str_replace('\\', '/', $route);

            $reflections[$route] = new \ReflectionClass($tool);
        }

        foreach ($reflections as $route => $reflection)
        {
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method)
            {
                $annotations = app('annotations')->getMethodAnnotations($method);

                $toolsAnnotations = array_filter($annotations, function ($item) {
                    return $item instanceof ToolsAnnotation;
                });

                if (count($toolsAnnotations) == 0)
                    continue;

                if (count($toolsAnnotations) > 1)
                    throw new \Exception('Each method must have exactly one ToolsAnnotation');

                $toolsAnnotation = $toolsAnnotations[0];

                // if this method is meant to be served, add it to the array
                if ($toolsAnnotation->serve) {

                    $methods[] = [
                        'name' => $toolsAnnotation->name,
                        'description' => $toolsAnnotation->description,
                        'route' => $route == 'tools' ? $method->name : $route
                    ];
                }
            }
        }

        Cache::forever('parser_tools_list', $methods);

        return $methods;
    }


    /**
     * Get list of tools in the application that are using ITool interface
     * Class does not have to be initialized, but it must be within \App\Tools namespace
     */
    private function getToolsByInterface()
    {
        $di = new \RecursiveDirectoryIterator(app_path('Tools'), \RecursiveDirectoryIterator::SKIP_DOTS);
        $it = new \RecursiveIteratorIterator($di);

        $files = [];
        $baseLen = strlen(base_path());

        foreach($it as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == "php") {

                //get namespace path
                $file = substr($file, $baseLen, -4);

                //explode elements by DS
                $file = explode(DIRECTORY_SEPARATOR, $file);

                //capitalize segments and glue them with \
                $file = implode('\\', array_map('ucfirst', $file));

                $interfaces = class_implements($file);

                //check does class implements needed interface
                if (isset($interfaces[Tools\Contracts\ITool::class])) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    public function compileVueRoutes()
    {
        $defaultRoutes = <<<'VUE'
/*** THIS FILE IS AUTO-GENERATED, DO NOT MODIFY IT ***/
module.exports = {
    routes: [
        { path: '/', component: require('./components/List.vue') },
%REPLACE%
    ]
};
VUE;

        $replace = '';

        foreach($this->getTools() as $tool){
            $replace .= "        { path: '/{$tool['route']}', component: require('./tools/{$tool['name']}.vue') }," . PHP_EOL;
        }

        return str_replace('%REPLACE%', $replace, $defaultRoutes);
    }
}