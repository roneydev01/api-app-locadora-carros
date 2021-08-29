<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeloRequest;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    /**
     * Instanciando o atributo que recebe o objeto
     */
    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modelos = array();
        //Ex. - atributos_marca=nome_coluna_1,nome_coluna_2, etc
        if ($request->has('atributos_marca')) {
            $atributos_marca = $request->atributos_marca;
            $modelos = $this->modelo->with('marca:id,'.$atributos_marca);
        }else {
            $modelos = $this->modelo->with('marca');
        }

        //Aplicando condições dos filtros enviados
        //Ex. - &filtro=nome_coluna:=:condicao_1;nome_coluna:=:condicao_2;nome_coluna:=:condicao_3;etc
        if ($request->has('filtro')) {
            $filtros = explode(';', $request->filtro);
            foreach ($filtros as $key => $condicao) {
                $c = explode(':', $condicao);
                $modelos = $modelos->where($c[0], $c[1], $c[2]);
            }
        }
        //Ex. - atributos=forkey,nome_coluna_1,nome_coluna_2, etc
        if ($request->has('atributos')) {
            $atributos = $request->atributos;
            $modelos = $modelos->selectRaw($atributos)->get();
        }else{
            $modelos = $modelos->get();
        }

        return response()->json($modelos,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ModeloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModeloRequest $request)
    {
        $dados = $request->except('imagem');

        if ($request->hasFile('imagem')) {

            $imagem = $request->file('imagem');
            //Salva imagem no disco local e a string de retono do caminho salvo no DB - É criado uma pasta imagens no path(storage/app/public/)
            $imagem_urn = $imagem->store('imagens/modelos', 'public');
            $dados['imagem'] = $imagem_urn;

        }

        $this->modelo->create($dados);

        return response()->json($dados,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if($modelo === null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
        return response()->json($modelo,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ModeloRequest  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModeloRequest $request, $id)
    {
        $modelo = $this->modelo->find($id);

        $dados = $request->except('imagem');

        if($modelo === null){
            return response()->json(['erro'=>'Atualização não realizada. Recurso pesquisado não existe', 404]);
        }

        if ($request->hasFile('imagem')) {
            //Remove o arquivo antigo caso exista quandoum novo arquivo tenha sido enviado no request
            if ($modelo->imagem) {
                Storage::disk('public')->delete($modelo->imagem);
            }

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/modelos', 'public');
            $dados['imagem'] = $imagem_urn;

        }
        //Preenche o objeto $marca com os dados do request
        $modelo->fill($dados);
        $modelo->save();
        //$modelo->update($dados);

        return response()->json($modelo,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->findOrFail($id);
        if($modelo === null){
            return response()->json(['erro'=>'Exclusão  não realizada. Recurso pesquisado não existe'], 404);
        }

         //Remove o arquivo caso exista no registro
        if ($modelo->imagem) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $modelo->delete();
        return response()->json(['msg', 'O modelo foi deletado com sucesso!'],200);
    }
}
