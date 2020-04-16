<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Validator;
use App\municipios;
use App\provincias;
use App\comuna;

class municipioController extends Controller
{
    public function addMunicipio(Request $request){
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'provincia_id' => 'required',
            'capital' => 'required|boolean',
            'populacao' => 'required|integer',
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
        $municipio->populacao= $request->input('populacao');
        $resposta=['success'=>false,'data'=>''];
        if ($municipio->save()) {
            $resposta=['success'=>true,'data'=>'municipio added com sucesso'];
        }
        return response()->json($resposta,200);
    }

    public function editMunicipio(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nome' => 'required|string',
            'provincia_id' => 'required',
            'capital' => 'required|boolean',
            'populacao' => 'required|integer',
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
        $municipio->populacao=$request->input('populacao');
        $resposta=['success'=>false,'data'=>''];
        if ($municipio->save()) {
            $resposta=['success'=>true,'data'=>'municipio editado com sucesso'];
        }
        return response()->json($resposta,200);
    }

    public function listarTodosMunicipios(){
        $municipios=new collection;
        $getMunicipios=municipios::all();
        $resposta=['success'=>false,'data'=>$municipios];
        if (count($getMunicipios)) {
            foreach ($getMunicipios as $municipio) {
                $municipios->push(array(
                    'id'=>$municipio->id,
                    'municipio'=>$municipio->nome,
                    'populacao'=>$municipio->populacao,
                    'comunas'=>count($this->comunas($municipio->id)),
                   # 'provincia'=>$this->listarProvincia($municipio->provincia_id),
                ));
            }
            $resposta=['success'=>true,'data'=>$municipios];
        }
        return response()->json($resposta);
    }

    public function listarProvincia($id){
        return provincias::where('id',[$id])
         ->value('nome');
     }
    public function comunas($id){
        return comuna::whereRaw('municipio_id=?',[$id])
         ->get();
     }
}
