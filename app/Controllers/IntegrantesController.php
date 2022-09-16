<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php');


use App\Models\GeneralFunctions;
use App\Models\Integrantes;


class IntegrantesController
{


    private array $dataIntegrante;

    public function  __construct(array $_FORM){

        $this->dataIntegrante =array();
        $this->dataIntegrante['id']=$_FORM['id']?? NULL;
        $this->dataIntegrante ['documentoTalento']=$_FORM['documentoTalento']?? '';
        $this->dataIntegrante ['tipoDocumento']=$_FORM['tipoDocumento']?? '';
        $this->dataIntegrante ['documentoFamiliar']=$_FORM['documentoFamiliar']?? '';
        $this->dataIntegrante ['nombreFamiliar']=$_FORM['nombreFamiliar'] ?? '';
        $this->dataIntegrante ['apellidoFamiliar']=$_FORM['apellidoFamiliar'] ?? '';
        $this->dataIntegrante ['telefono']=$_FORM['telefono']?? '';
        $this->dataIntegrante ['parentesco']=$_FORM['parentesco']?? '';
        $this->dataIntegrante ['estado']=$_FORM['estado'] ?? 'Activo';
        $this->dataIntegrante ['talentos_id']=$_FORM['talentos_id']?? 0;


    }


    public function create() {
        try {
            if (!empty($this->dataIntegrante['documentoFamiliar']) && !Integrantes::integranteRegistrado($this->dataIntegrante['documentoFamiliar'])) {
                $Integrante = new Integrantes ($this->dataIntegrante);
                if ($Integrante->insert()) {
                    unset($_SESSION['frmCreateIntegrante']);
                    header("Location: ../../views/modules/integrantes/index.php?respuesta=success&mensaje= Registrado!");
                }
            } else {
                header("Location: ../../views/modules/integrantes/create.php?respuesta=error&mensaje= ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Integrante = new Integrantes($this->dataIntegrante);
            if($Integrante->update()){
                unset($_SESSION['frmEditIntegrante']);
                header("Location: ../../views/modules/integrantes/show.php?id=" . $Integrante->getId() . "&respuesta=success&mensaje= Actualizado");
            }else{
                header("Location: ../../views/modules/integrantes/edit.php?id=" . $Integrante->getId() . "&respuesta=error&mensaje= No actualizado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            header("Location: ../../views/modules/integrantes/edit.php?id=" . $Integrante->getId() . "&respuesta=error&mensaje=".$e);
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Integrantes::searchForId($data['id']);
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
            $result = Integrantes::getAll();
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
            $ObjIntegrante = Integrantes::searchForId($id);
            $ObjIntegrante->setEstado("Activo");
            if($ObjIntegrante->update()){
                header("Location: ../../views/modules/integrantes/index.php");
            }else{
                header("Location: ../../views/modules/integrantes/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjIntegrante = Integrantes::searchForId($id);
            $ObjIntegrante->setEstado("Inactiva");
            if ($ObjIntegrante->update()) {
                header("Location: ../../views/modules/integrantes/index.php");
            } else {
                header("Location: ../../views/modules/integrantes/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }


    static public function selectIntegrante(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "integrante_id";
        $params['name'] = $params['name'] ?? "integrante_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrIntegrantes = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM integrantes WHERE ";
            $arrIntegrantes = Integrantes::search($base . ' ' . $params['where']);
        } else {
            $arrIntegrantes = Integrantes::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrIntegrantes) && count($arrIntegrantes) > 0) {
            /* @var $arrIntegrantes Integrantes[] */
            foreach ($arrIntegrantes as $integrante)
                if (!IntegrantesController::integranteIsInArray($integrante->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($integrante != "") ? (($params['defaultValue'] == $integrante->getId()) ? "selected" : "") : "") . " value='" . $integrante->getId() . "'>"."# " . $integrante->getId(). " - "." " . $integrante->getId(). "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function integranteIsInArray($id, $ArrIntegrantes)
    {
        if (count($ArrIntegrantes) > 0) {
            foreach ($ArrIntegrantes as $Integrante) {
                if ($Integrante->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}
