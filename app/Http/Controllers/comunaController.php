<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\comuna;

class comunaController extends Controller
{
    public function addComuna(Request $request){
        $validator = Validator::make($request->all(), [
            'comuna' => 'required|string',
            'municipio_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'data' => [
                    $validator->errors(),
                ],
            ], 401);
        }
        $comuna= new comuna;
        $comuna->comuna=$request->input('comuna');
        $comuna->municipio_id=$request->input('municipio_id');

        $resposta=['success'=>false,'data'=>''];
        if ($comuna->save()) {
            $resposta=['success'=>true,'data'=>'comuna added com sucesso'];
        }
        return response()->json($resposta,200);
    }
}
