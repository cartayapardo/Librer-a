<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $mainteiner = $this->model::all();
        return ['success' => true, 'data' => $mainteiner, 'sms' => 'data cargados correctamente'];
    }

    public function store(Request $request)
    {
        $new = $this->model->create($request->all());
        if(!$new){
            return ['success' => false, 'data' => null, 'sms' => 'Existe un error en la creación del elemento'];
        }
        return ['success' => true, 'data' => $new, 'sms' => 'Creación del elemento con éxito'];
    }

    public function update(Request $request, int $id)
    {
        $element = $this->find($id);
        if (!$element){
            return ['success' => false, 'data' => null, 'sms' => 'No existe el elemento'];
        }
        $edit = $element->update($request->all());
        if(!$edit){
            return ['success' => false, 'data' => null, 'sms' => 'Existe un error en la actualización del elemento'];
        }
        return ['success' => true, 'data' => $id, 'sms' => 'Actualización de los datos con éxito'];
    }

    public function destroy(Request $request, int $id)
    {
        $delete = $this->model->destroy($id);
        if(!$delete){
            return ['success' => false, 'data' => null, 'sms' => 'Ocurrió un error eliminando el elemento'];
        }
        return ['success' => true, 'data' => $id, 'sms' => 'Elemento eliminado con éxito'];
    }

    public function find($id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }
}
