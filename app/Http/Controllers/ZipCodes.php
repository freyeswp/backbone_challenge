<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZipCodes extends Controller
{
    public function show ( $zip_code ){
        return response()->json(array( 'data' => $zip_code ) );
    }
}
