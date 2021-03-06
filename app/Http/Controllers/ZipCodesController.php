<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZipCodesController extends Controller
{
    public function show ( $zip_code ) {

        try {

            //Get data in the JSON fil
            $zip_codes   = json_decode( file_get_contents( storage_path()."/app/public/json/zip_codes.json" ), true );
            $zip_codes   = array_filter($zip_codes);
            $data        = collect( $zip_codes )->where( "d_codigo", "=", "$zip_code" )->values( )->all( );
            $settlements = array();

            //Loop for get the settlements array
            foreach( $data as $d ){
                $settlement = array(
                    "key"             => intval( $d['id_asenta_cpcons'] ),
                    "name"            => self::format($d['d_asenta']),
                    "zone_type"       => strtoupper( $d['d_zona'] ),
                    "settlement_type" => array(
                        "name" => $d[ 'd_tipo_asenta' ],
                    )
                );
                array_push( $settlements, $settlement );
            }


            //Response body
            $response = array(
                "zip_code"       => $data[ 0 ][ 'd_codigo' ] ?? '',
                "locality"       => self::format( $data[ 0 ][ 'd_ciudad' ] ) ?? '',
                "federal_entity" => array(
                    "key"  => intval( $data[ 0 ][ 'c_estado' ] ) ?? '',
                    "name" => self::format( $data[ 0 ][ 'd_estado' ] ) ?? '',
                    "code" => null
                ),
                "settlements"  => $settlements,
                "municipality" => array(
                    "key"  => intval( $data[ 0 ][ 'c_mnpio' ] ) ?? '',
                    "name" => self::format( $data[ 0 ][ 'D_mnpio' ] ) ?? ''
                ),
            );

            //Response
            return response( )->json(  $response, 200 );

        }catch (\Exception $e) {

            return response( )->json( array( 'code'=>$e->getCode(), 'data'=>$e->getMessage() ),400 );

        }
    }


    private function format ( $words ) {
        //Special characters
        $table = array(
            '??'=>'S', '??'=>'s', '??'=>'Dj', '??'=>'dj', '??'=>'Z', '??'=>'z', '??'=>'C', '??'=>'c', '??'=>'C', '??'=>'c',
            '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'C', '??'=>'E', '??'=>'E',
            '??'=>'E', '??'=>'E', '??'=>'I', '??'=>'I', '??'=>'I', '??'=>'I', '??'=>'N', '??'=>'O', '??'=>'O', '??'=>'O',
            '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'U', '??'=>'U', '??'=>'U', '??'=>'U', '??'=>'Y', '??'=>'B', '??'=>'Ss',
            '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'c', '??'=>'e', '??'=>'e',
            '??'=>'e', '??'=>'e', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'i', '??'=>'o', '??'=>'n', '??'=>'o', '??'=>'o',
            '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'y', '??'=>'y', '??'=>'b',
            '??'=>'y', '??'=>'R', '??'=>'r',
        );

        return strtoupper( strtr( $words, $table ) );
    }
}
