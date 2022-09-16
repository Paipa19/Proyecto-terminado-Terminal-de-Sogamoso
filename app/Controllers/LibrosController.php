<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Libros;


class LibrosController
{
    private array $dataLibro;

    public function  __construct(array $_FORM){

        $this->dataLibro =array();
        $this->dataLibro['id']=$_FORM['id']?? NULL;
        $this->dataLibro ['disposicionFinal']=$_FORM['disposicionFinal']?? NULL;
        $this->dataLibro ['retencion']=$_FORM['retencion'] ?? NULL;
        $this->dataLibro ['estanteLibro']=$_FORM['estanteLibro']?? '';
        $this->dataLibro ['nivelLibro']=$_FORM['nivelLibro']?? '';
        $this->dataLibro ['cantidad']=$_FORM['cantidad']?? '';
        $this->dataLibro ['numBoletin']=$_FORM['numBoletin']??'';
        $this->dataLibro ['numComprobante']=$_FORM['numComprobante']?? '';
        $this->dataLibro ['mes']=$_FORM['mes']?? '';
        $this->dataLibro ['agenda']=$_FORM['agenda']?? '';
        $this->dataLibro ['usuarios_id']=$_FORM['usuarios_id']?? 0;


    }

    public function create() {
        try {
            $Libro = new Libros($this->dataLibro);
            if ($Libro->insert()) {
                unset($_SESSION['frmCreateLibro']);
                $Libro->Connect();
                $id = $Libro->getLastId('libros');
                $Libro->Disconnect();
                header("Location: ../../views/modules/libros/index.php?id=" . $id . "&respuesta=success&mensaje=  Registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            //header("Location: ../../views/modules/libros/create.php?respuesta=error");
        }
    }

    public function edit()
    {
        try {
            $Libro= new Libros($this->dataLibro);
            if($Libro->update()){
                unset($_SESSION['frmEditLibro']);
                header("Location: ../../views/modules/libros/show.php?id=" . $Libro->getId() . "&respuesta=success&mensaje= Actualizado");
            }else{
                header("Location: ../../views/modules/libros/edit.php?id=" . $Libro->getId() . "&respuesta=error&mensaje= No actualizado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            header("Location: ../../views/modules/libros/edit.php?id=" . $Libro->getId() . "&respuesta=error&mensaje=".$e);
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Libros::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function getAll (array $data = null){
        try {
            $result = Libros::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }



    static public function selectContratos(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "libro_id";
        $params['name'] = $params['name'] ?? "libro_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrLibros = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM libros WHERE ";
            $arrLibros = Libros::search($base . ' ' . $params['where']);
        } else {
            $arrLibros = Libros::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrLibros) && count($arrLibros) > 0) {
            /* @var $arrLibros Libros[] */
            foreach ($arrLibros as $libro)
                if (!LibrosController::libroIsInArray($libro->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($libro != "") ? (($params['defaultValue'] == $libro->getId()) ? "selected" : "") : "") . " value='" . $libro->getId() . "'>" . $libro->getId() . " - ".$libro->getId() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function libroIsInArray($id, $ArrLibros)
    {
        if (count($ArrLibros) > 0) {
            foreach ($ArrLibros as $Libro) {
                if ($Libro->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}


