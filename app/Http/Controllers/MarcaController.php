<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;

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
        $marcas = $this->marca->with('modelos')->get();
        return response()->json($marcas,200);
    }

    /**
     *
     * @param  \Illuminate\Http\Requests\MarcaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarcaRequest $request)
    {
        // dd($request->nome);
        // dd($request->get('nome'));
        // dd($request->imagem);
        // dd($request->file('imagem'));
        //$marca = Marca::create($request->all());

        $imagem = $request->file('imagem');
        //Salva imagem no disco local e a string de retono do caminho salvo no DB - É criado uma pasta imagens no path(storage/app/public/)
        $imagem_urn = $imagem->store('imagens/marcas', 'public');
        //Cria no DB
        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        return response()->json($marca,201);
    }

    /**
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
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
        $imagem_urn = '';

        if($marca === null){
            return response()->json(['erro'=>'Atualização não realizada. Recurso pesquisado não existe', 404]);
        }

        if ($request->file('imagem')) {
            //Remove o arquivo antigo caso exista quandoum novo arquivo tenha sido enviado no request
            if ($marca->imagem) {
                Storage::disk('public')->delete($marca->imagem);
            }

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/marcas', 'public');
        }

        //Preenche o objeto $marca com os dados do request (Caso seja enviado com method patch não dará problema)
        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();

        // $marca->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);
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

         //Remove o arquivo caso exista no registro
        if ($marca->imagem) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $marca->delete();
        return response()->json(['msg', 'A marca foi deletada com sucesso!'],200);
    }
}
