<?php

namespace App\Controllers;
require (__DIR__.'/../../vendor/autoload.php');

use App\Models\GeneralFunctions;
use App\Models\Egresos;
use Carbon\Carbon;

class EgresosController
{
    private array $dataEgreso;

    public function __construct(array $_FORM)
    {

        $this->dataEgreso = array();
        $this->dataEgreso['id'] = $_FORM['id'] ?? NULL;
        $this->dataEgreso ['numeroComprobante'] = $_FORM['numeroComprobante'] ??'';
        $this->dataEgreso ['fechaComprobante'] = $_FORM['fechaComprobante'] ?? '';
        $this->dataEgreso ['nombreBeneficiario'] = $_FORM['nombreBeneficiario'] ?? '';
        $this->dataEgreso ['numeroIdentificacion'] = $_FORM['numeroIdentificacion'] ?? '';
        $this->dataEgreso ['concepto'] = $_FORM['concepto'] ?? '';
        $this->dataEgreso ['numContrato'] = $_FORM['numContrato'] ?? '';
        $this->dataEgreso ['fechaContrato'] = $_FORM['fechaContrato'] ?? '';
        $this->dataEgreso ['usuarios_id'] = $_FORM['usuarios_id'] ?? 0;

    }

    public function create()
    {
        try {
            if (!empty($this->dataEgreso['numeroComprobante']) && !Egresos::egresoRegistrado($this->dataEgreso['numeroComprobante'])) {
                $Egreso = new Egresos ($this->dataEgreso);
                if ($Egreso->insert()) {
                    unset($_SESSION['frmCreateEgreso']);
                    header("Location: ../../views/modules/egresos/index.php?respuesta=success&mensaje= Registrado");
                }
            } else {
                header("Location: ../../views/modules/egresos/create.php?respuesta=error&mensaje= Ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Egreso = new Egresos($this->dataEgreso);
            if ($Egreso->update()) {
                unset($_SESSION['frmEditEgreso']);
                header("Location: ../../views/modules/egresos/show.php?id=" . $Egreso->getId() . "&respuesta=success&mensaje= Actualizado");
            } else {
                header("Location: ../../views/modules/egresos/edit.php?id=" . $Egreso->getId() . "&respuesta=error&mensaje= No actualizado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
            header("Location: ../../views/modules/egresos/edit.php?id=" . $Egreso->getId() . "&respuesta=error&mensaje=" . $e);
        }
    }

    static public function searchForID(array $data)
    {
        try {
            $result = Egresos::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    static public function getAll(array $data = null)
    {
        try {
            $result = Egresos::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }



    static public function selectEgreso(array $params = [])
    {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "egreso_id";
        $params['name'] = $params['name'] ?? "egreso_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrEgresos = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM egresos WHERE ";
            $arrEgresos = Egresos::search($base . ' ' . $params['where']);
        } else {
            $arrEgresos = Egresos::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrEgresos) && count($arrEgresos) > 0) {
            /* @var $arrEgresos Egresos[] */
            foreach ($arrEgresos as $egreso)
                if (!EgresosController::egresoIsInArray($egreso->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($egreso != "") ? (($params['defaultValue'] == $egreso->getId()) ? "selected" : "") : "") . " value='" . $egreso->getId() . "'>"."# " . $egreso->getId(). " - Número de Identificación  "." " . $egreso->getNumeroIdentificacion() . "  - Nombre Beneficiario   " . $egreso->getNombreBeneficiario() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function egresoIsInArray($id, $ArrEgresos)
    {
        if (count($ArrEgresos) > 0) {
            foreach ($ArrEgresos as $Egreso) {
                if ($Egreso->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}