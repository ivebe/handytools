<?php

namespace App\Http\Controllers;

use App\Annotations\ToolsAnnotation;
use App\IParser;
use App\Parser;
use App\Tools;
use Doctrine\Common\Annotations\Reader;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function index(IParser $parser)
    {
        return response()->json( $parser->getTools() );
    }

    /**
     * When serving the tool we just call the same name function from tools
     *
     * @param $name
     * @param Request $request
     * @return mixed
     */
    public function serve($name, Request $request)
    {
        if(method_exists($this->tools, $name))
            return $this->tools->$name($request);

        /** see is there such tool with ITool interface **/

        return $this->callNamespacedToolIfExists($name, 'get', $request);
    }

    /**
     * Response from tools is processed in _NAME functions
     *
     * @param $name
     * @param Request $request
     * @return mixed
     */
    public function response($name, Request $request)
    {
        $_name = '_' . $name;

        if(method_exists($this->tools, $_name))
            return $this->tools->$_name($request);

        /** see is there such tool with ITool interface **/

        return $this->callNamespacedToolIfExists($name, 'post', $request);
    }

    /**
     * @param $name namespaced part of the URL
     * @param $method get/post
     * @param $request forwarded Request object
     * @return mixed
     */
    private function callNamespacedToolIfExists($name, $method, $request)
    {
        //explode elements by DS
        $namespaced = explode('/', $name);

        //capitalize segments and glue them with \
        $namespaced = '\\App\\Tools\\' . implode('\\', array_map('ucfirst', $namespaced));

        if(method_exists($namespaced, $method)){
            $tool = new $namespaced;
            return $tool->$method($request);
        }

        abort(404);
    }
}
