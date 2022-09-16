<?php

namespace App\Controllers;
require (__DIR__.'/../../vendor/autoload.php');

use App\Models\Egresos;
use App\Models\GeneralFunctions;
use App\Models\Ingresos;
use Carbon\Carbon;

class IngresosController
{
    private array $dataIngreso;

    public function  __construct(array $_FORM){

        $this->dataIngreso =array();
        $this->dataIngreso['id']=$_FORM['id']?? NULL;
        $this->dataIngreso ['numeroCaja']=$_FORM['numeroCaja']?? '';
        $this->dataIngreso ['numeroBoletin']=$_FORM['numeroBoletin']?? '';
        $this->dataIngreso ['fecha']=$_FORM['fecha']??'';
        $this->dataIngreso ['nombreBeneficiario']=$_FORM['nombreBeneficiario']?? '';
        $this->dataIngreso ['numeroRecibo']=$_FORM['numeroRecibo']??'';
        $this->dataIngreso ['concepto']=$_FORM['concepto'] ??'';
        $this->dataIngreso ['estado']=$_FORM['estado'] ?? "Activo";
        $this->dataIngreso ['usuarios_id']=$_FORM['usuarios_id']?? 0;

    }

    public function create() {
        try {
                $Ingreso = new Ingresos ($this->dataIngreso);
                if ($Ingreso->insert()) {
                    unset($_SESSION['frmCreateIngreso']);
                    header("Location: ../../views/modules/ingresos/index.php?respuesta=success&mensaje= Registrado");
            } else {
                header("Location: ../../views/modules/ingresos/create.php?respuesta=error&mensaje= Ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Ingreso= new Ingresos($this->dataIngreso);
            if($Ingreso->update()){
                unset($_SESSION['frmEditIngreso']);
                header("Location: ../../views/modules/ingresos/show.php?id=" . $Ingreso->getId() . "&respuesta=success&mensaje= Actualizado");
            }else{
                header("Location: ../../views/modules/ingresos/edit.php?id=" . $Ingreso->getId() . "&respuesta=error&mensaje= No actualizado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            header("Location: ../../views/modules/ingresos/edit.php?id=" . $Ingreso->getId() . "&respuesta=error&mensaje=".$e);
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Ingresos::searchForId($data['id']);
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
            $result = Ingresos::getAll();
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


    static public function selectIngreso(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "ingreso_id";
        $params['name'] = $params['name'] ?? "ingreso_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrIngresos = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM ingresos WHERE ";
            $arrIngresos = Ingresos::search($base . ' ' . $params['where']);
        } else {
            $arrIngresos = Ingresos::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrIngresos) && count($arrIngresos) > 0) {
            /* @var $arrIngresos Ingresos[] */
            foreach ($arrIngresos as $ingreso)
                if (!IngresosController::ingresoIsInArray($ingreso->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($ingreso != "") ? (($params['defaultValue'] == $ingreso->getId()) ? "selected" : "") : "") . " value='" . $ingreso->getId() . "'>"."# " . $ingreso->getId(). " - Número Boletín  " . $ingreso->getNumeroBoletin() ." - Número Recibo " . $ingreso->getNumeroRecibo() ." - Nombre Beneficiario " . $ingreso->getNombreBeneficiario() . "</option>";        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function ingresoIsInArray($id, $ArrIngresos)
    {
        if (count($ArrIngresos) > 0) {
            foreach ($ArrIngresos as $Ingreso) {
                if ($Ingreso->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}



