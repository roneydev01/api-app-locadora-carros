<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;

class MarcaController extends Controller
{
    /**
     * Instanciando o atributo que recebe o objeto
     */
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $marca = Marca::all();
        $marcas = $this->marca->all();
        return response()->json($marcas,200);
    }

    /**
     *
     * @param  \Illuminate\Http\Requests\MarcaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarcaRequest $request)
    {
        //$marca = Marca::create($request->all());
        $marca = $this->marca->create($request->all());
        return response()->json($marca,201);
    }

    /**
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
        return response()->json($marca,200);
    }

    /**
     *
     * @param  \Illuminate\Http\Requests\MarcaRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(MarcaRequest $request, $id)
    {
        // print_r($request->all());
        // //Dados antigos
        // print_r($marca->getAttributes());
        // $marca->update($request->all());
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro'=>'Atualização não realizada. Recurso pesquisado não existe', 404]);
        }

        $marca->update($request->all());
        return response()->json($marca,200);
    }

    /**
     *
     * @param  integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro'=>'Exclusão  não realizada. Recurso pesquisado não existe'], 404);
        }
        $marca->delete();
        return response()->json(['msg', 'A marca foi deletada com sucesso!'],200);
    }
}
