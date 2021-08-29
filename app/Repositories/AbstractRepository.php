<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class utilizando Repository Design Pattern, para tartar as regras de negócio sobre o Model, onde a mesma faz um ponte entre o Controller e Model
 */
class AbstractRepository {

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAtributosRegistrosRelacionados($atributos)
    {
        //Query está sendo montada
        $this->model = $this->model->with($atributos);
    }

    public function filtro($filtro) {
        $filtros = explode(';', $filtro);
        foreach ($filtros as $key => $condicao) {
            $c = explode(':', $condicao);
            //Query está sendo montada
            $this->model = $this->model->where($c[0], $c[1], $c[2]);
        }
    }

    public function selectAtributos($atributos)
    {
        //Query está sendo montada
        $this->model = $this->model->selectRaw($atributos);
    }

    public function getResultado()
    {
        return $this->model->get();
    }
}
