<?php

namespace App;

use Illuminate\Http\Request;
use App\Annotations\ToolsAnnotation;



class Tools
{
    /**
     * @ToolsAnnotation(
     *     name="md5",
     *     serve=true,
     *     description="Hash string using md5 algorithm"
     * )
     */
    public function md5( Request $request )
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function _md5( Request $request )
    {
        return response()->json([
            'md5' => md5($request->get('input'))
        ]);
    }

    /**
     * @ToolsAnnotation(
     *     name="bcrypt",
     *     serve=true,
     *     description="Hash string using bcrypt algorithm"
     * )
     */
    public function bcrypt()
    {}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function _bcrypt( Request $request )
    {
        return response()->json([
            'md5'   => md5($request->get('input')),
            'hash'  => \Hash::make($request->get('input')),
            'match' => \Hash::check($request->get('input'), $request->get('hash'))
        ]);
    }

    /**
     * @ToolsAnnotation(
     *     name="base64",
     *     serve=true,
     *     description="Base64 encode/decode"
     * )
     */
    public function base64()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function _base64( Request $request )
    {
        if( $request->get('action') == "true" )
            return response()->json([
                'data' => base64_encode($request->get('data')),
            ]);

        return response()->json([
            'data' => utf8_encode( base64_decode( $request->get('data')) ),
        ]);
    }

    /**
     * @ToolsAnnotation(
     *     name="passwd",
     *     serve=true,
     *     description="Random password generator"
     * )
     */
    public function passwd()
    {
        return response()->json([
            'passwd' => utf8_encode( str_random(8) )
        ]);
    }

    public function _passwd( Request $request )
    {
        if($request->length == '')
            $lenght = 32;
        else
            $lenght = $request->length;

        if($request->specialChar == 'true')
        {
            $specChar = str_split("#$%^&*()+=-[]';,./{}|:<>?~");
            shuffle($specChar);
            $count = round($lenght/3);
            $string = str_split(str_random($lenght-$count));
            $string = array_merge($string,array_slice($specChar, 0, $count));
            shuffle($string);
            $string = implode($string);
        }
        else
        {
            $string = str_random($lenght);
        }



        return response()->json([
            'passwd' => utf8_encode($string)
        ]);
    }

    /**
     * @ToolsAnnotation(
     *     name="urlencdec",
     *     serve=true,
     *     description="Url Encode / Decode"
     * )
     */
    public function urlencdec()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function _urlencdec( Request $request )
    {
        if( $request->get('action') == "true" )
            return response()->json([
                'data' => urlencode($request->get('data')),
            ]);

        return response()->json([
            'data' => utf8_encode( urldecode( $request->get('data')) ),
        ]);
    }

    /**
    * @ToolsAnnotation(
    *     name="comparefiles",
    *     serve=true,
    *     description="diff"
    * )
    */
    public function comparefiles()
    {
    }
    /**
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    */
    public function _comparefiles( Request $request )
    {
    return response()->json([
    'text' => utf8_encode('blabla')
    ]);
    }
}
