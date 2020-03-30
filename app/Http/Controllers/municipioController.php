<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\municipios;

class municipioController extends Controller
{
    public function addMunicipio(Request $request){
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'provincia_id' => 'required|numeric',
            'capital' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'data' => [
                    $validator->errors(),
                ],
            ], 401);
        }
        $municipio= new municipios;
        $municipio->nome=$request->input('nome');
        $municipio->provincia_id=$request->input('provincia_id');
        $municipio->capital=$request->input('capital');
        $resposta=['success'=>false,'data'=>''];
        if ($municipio->save()) {
            $resposta=['success'=>true,'data'=>'municipio added com sucesso'];
        }
        return response()->json($resposta,200);
    }

    public function editMunicipio(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'nome' => 'required|string',
            'provincia_id' => 'required|numeric',
            'capital' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'data' => [
                    $validator->errors(),
                ],
            ], 401);
        }
        $municipio= municipios::find($request->input('id'));
        $municipio->nome=$request->input('nome');
        $municipio->provincia_id=$request->input('provincia_id');
        $municipio->capital=$request->input('capital');
        $resposta=['success'=>false,'data'=>''];
        if ($municipio->save()) {
            $resposta=['success'=>true,'data'=>'municipio editado com sucesso'];
        }
        return response()->json($resposta,200);
    }
}
