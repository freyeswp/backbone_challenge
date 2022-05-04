<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZipCodesController extends Controller
{
    public function show ( $zip_code ) {

        try {

            return public_path()."\json\zip_codes.json" ;
            //Get data in the JSON fil
            $zip_codes   = json_decode( file_get_contents( public_path()."\json\zip_codes.json" ), true );
            $zip_codes   = array_filter($zip_codes);
            $data        = collect( $zip_codes )->where( "d_codigo", "=", "$zip_code" )->values( )->all( );
            $settlements = array();

            //Loop for get the settlements array
            foreach( $data as $d ){
                $settlement = array(
                    "key"             => intval( $d['id_asenta_cpcons'] ),
                    "name"            => strtoupper( $d['d_asenta'] ),
                    "zone_type"       => strtoupper( $d['d_zona'] ),
                    "settlement_type" => array(
                        "name" => $d[ 'd_tipo_asenta' ],
                    )
                );
                array_push( $settlements, $settlement );
            }

            //Special characters
            $table = array(
                'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
                'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
                'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
                'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
                'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
                'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
                'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
            );

            //Response body
            $response = array(
                "zip_code"       => $data[ 0 ][ 'd_codigo' ] ?? '',
                "locality"       => strtoupper( strtr( $data[ 0 ][ 'd_ciudad' ], $table ) ) ?? '',
                "federal_entity" => array(
                    "key"  => intval( $data[ 0 ][ 'c_estado' ] ) ?? '',
                    "name" => strtoupper( strtr( $data[ 0 ][ 'd_estado' ], $table ) ) ?? '',
                    "code" => null
                ),
                "settlements"  => $settlements,
                "municipality" => array(
                    "key"  => intval( $data[ 0 ][ 'c_mnpio' ] ) ?? '',
                    "name" => strtoupper( strtr( $data[ 0 ][ 'D_mnpio' ], $table ) ) ?? ''
                ),
            );

            //Response
            return response( )->json(  $response, 200 );

        }catch (\Exception $e) {

            return response( )->json( array( 'code'=>$e->getCode(), 'data'=>$e->getMessage() ),400 );

        }
    }
}
