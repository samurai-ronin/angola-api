<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Validator;
use App\provincias;

class provinceController extends Controller
{
    public function listar(Request $request){
        $provincias=new collection;
        $provinces=provincias::all();
        $resposta=['success'=>false,'data'=>$provinces];
        if (count($provinces)) {
            foreach ($provinces as $province) {
                $provincias->push(array(
                    'id'=>$province->id,
                    'provincia'=>$province->nome,
                    'capital'=>$this->listarCapital($province->id),
                    'extensao'=>$province->extensao,
                    'municipios'=>count($this->listarMunicipios($province->id)),
                ));
            }
            $resposta=['success'=>true,'data'=>$provincias];
        }
        return response()->json($resposta);
    }

    public function detalhes($id){
        $provincia=new collection;
        $province=provincias::find($id);
        $resposta=['success'=>false,'data'=>[]];
        if ($province){
                $provincia->push(array(
                    'id'=>$province->id,
                    'provincia'=>$province->nome,
                    'capital'=>$this->listarCapital($id),
                    'extensao'=>$province->extensao,
                    'municipios'=>$this->listarMunicipios($province->id),
                ));
                $resposta=['success'=>true,'data'=>$provincia];
            }
        return response()->json($resposta);
    }

    public function listarMunicipios($id){
       return DB::table('municipios')
       ->selectRaw('id,nome')
        ->where('provincia_id',[$id])
        ->get();
    }
    
    public function listarCapital($id){
       return DB::table('municipios')
      # ->selectRaw('nome')
        ->whereRaw('provincia_id=? and capital=1',[$id])
        ->value('nome');
    }

    public function addProvincia(Request $request){
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'extensao' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'data' => [
                    $validator->errors(),
                ],
            ], 401);
        }
        $provincia= new provincias;
        $provincia->nome=$request->input('nome');
        $provincia->extensao=$request->input('extensao');
        $resposta=null;
        if ($provincia->save()) {
            $resposta=['success'=>true,'data'=>'Provincia added com sucesso'];
        }
        return response()->json($resposta,200);
    }
}
