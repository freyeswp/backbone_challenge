<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZipCodes extends Controller
{
    public function show ( $zip_code ){
        $zip_codes = json_decode(file_get_contents(storage_path()."\json\zip_codes.json"), true);
        $zip_codes = array_filter($zip_codes);
        $zip_codes = collect($zip_codes)->where("d_codigo", "LIKE", "$zip_code")->all();

        $data = array(
            "zip_code" => '',
            "locality" => '',
            "federal_entity" => array(
                "key" => '',
                "name" => '',
                "code" => ''
            ),
            "settlements" => array(
                array(
                    "key" => '',
                    "name" => '',
                    "code" => ''
                )
            ),
            "municipality" => array(
                "key" => '',
                "name" => ''
            ),
        );
        return response()->json(array( 'data' => $data ) );
    }
}
