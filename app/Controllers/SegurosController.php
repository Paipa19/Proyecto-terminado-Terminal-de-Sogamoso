<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php');

use App\Models\Talentos;
use App\Models\GeneralFunctions;
use App\Models\Seguros;

class SegurosController
{

    private array $dataSeguro;

    public function  __construct(array $_FORM){

        $this->dataSeguro =array();
        $this->dataSeguro['id']=$_FORM['id']?? NULL;
        $this->dataSeguro ['documento']=$_FORM['documento']?? '';
        $this->dataSeguro ['salud']=$_FORM['salud']?? '';
        $this->dataSeguro ['pension']=$_FORM['pension']?? '';
        $this->dataSeguro ['riegosLaborales']=$_FORM['riegosLaborales'] ?? '';
        $this->dataSeguro ['estado']=$_FORM['estado'] ?? 'Activo';
        $this->dataSeguro ['talentos_id']=$_FORM['talentos_id']?? 0;

    }

    public function create() {
        try {
            if (!empty($this->dataSeguro['documento']) && !Seguros::seguroRegistrado($this->dataSeguro['documento'])) {
                $Seguro = new Seguros ($this->dataSeguro);
                if ($Seguro->insert()) {
                    unset($_SESSION['frmCreateSeguro']);
                    header("Location: ../../views/modules/seguros/index.php?respuesta=success&mensaje= Registrado!");
                }
            } else {
                header("Location: ../../views/modules/seguros/create.php?respuesta=error&mensaje= ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Seguro = new Seguros($this->dataSeguro);
            if($Seguro->update()){
                unset($_SESSION['frmEditSeguro']);
                header("Location: ../../views/modules/seguros/show.php?id=" . $Seguro->getId() . "&respuesta=success&mensaje= Actualizado");
            }else{
                header("Location: ../../views/modules/seguros/edit.php?id=" . $Seguro->getId() . "&respuesta=error&mensaje=  No actualizado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            header("Location: ../../views/modules/seguros/edit.php?id=" . $Seguro->getId() . "&respuesta=error&mensaje=".$e);
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Seguros::searchForId($data['id']);
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
            $result = Seguros::getAll();
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

    static public function activate (int $id){
        try {
            $ObjSeguros = Seguros::searchForId($id);
            $ObjSeguros->setEstado("Activo");
            if($ObjSeguros->update()){
                header("Location: ../../views/modules/seguros/index.php");
            }else{
                header("Location: ../../views/modules/seguros/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjSeguros = Seguros::searchForId($id);
            $ObjSeguros->setEstado("Inactiva");
            if ($ObjSeguros->update()) {
                header("Location: ../../views/modules/seguros/index.php");
            } else {
                header("Location: ../../views/modules/seguros/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }

    }

    static public function selectSeguros(array $params = []) {

    $params['isMultiple'] = $params['isMultiple'] ?? false;
    $params['isRequired'] = $params['isRequired'] ?? true;
    $params['id'] = $params['id'] ?? "seguro_id";
    $params['name'] = $params['name'] ?? "seguro_id";
    $params['defaultValue'] = $params['defaultValue'] ?? "";
    $params['class'] = $params['class'] ?? "form-control";
    $params['where'] = $params['where'] ?? "";
    $params['arrExcluir'] = $params['arrExcluir'] ?? array();
    $params['request'] = $params['request'] ?? 'html';

    $arrSeguros = array();
    if ($params['where'] != "") {
        $base = "SELECT * FROM seguros WHERE ";
        $arrSeguros = Seguros::search($base . ' ' . $params['where']);
    } else {
        $arrSeguros = seguros::getAll();
    }
    $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
    $htmlSelect .= "<option value='' >Seleccione</option>";
    if (is_array($arrSeguros) && count($arrSeguros) > 0) {
        /* @var $arrSeguros Seguros[] */
        foreach ($arrSeguros as $seguro)
            if (!SegurosController::seguroIsInArray($seguro->getId(), $params['arrExcluir']))
                $htmlSelect .= "<option " . (($seguro != "") ? (($params['defaultValue'] == $seguro->getId()) ? "selected" : "") : "") . " value='" . $seguro->getId() . "'>"."# " . $seguro->getId(). " - "."  " . $seguro->getId() . "</option>";
    }
    $htmlSelect .= "</select>";
    return $htmlSelect;
}

    private static function seguroIsInArray($id, $ArrSeguros)
    {
        if (count($ArrSeguros) > 0) {
            foreach ($ArrSeguros as $Seguro) {
                if ($Seguro->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}



