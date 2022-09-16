<?php


namespace App\Controllers;
require (__DIR__.'/../../vendor/autoload.php');

use App\Models\GeneralFunctions;;
use App\Models\Talentos;
use Carbon\Carbon;


class TalentosController

{
    private array $dataTalentoHumano;

    public function  __construct(array $_FORM)
    {

        $this->dataTalentoHumano = array();
        $this->dataTalentoHumano['id'] = $_FORM['id'] ?? NULL;
        $this->dataTalentoHumano['tipoDocumento'] = $_FORM['tipoDocumento'] ?? NULL;
        $this->dataTalentoHumano ['documento'] = $_FORM['documento'] ?? '';
        $this->dataTalentoHumano['nombres'] = $_FORM['nombres'] ?? '';
        $this->dataTalentoHumano['apellidos'] = $_FORM['apellidos'] ?? '';
        $this->dataTalentoHumano['estadoCivil'] = $_FORM['estadoCivil'] ?? '';
        $this->dataTalentoHumano['telefono'] = $_FORM['telefono'] ?? '';
        $this->dataTalentoHumano['direccion'] = $_FORM['direccion'] ?? '';
        $this->dataTalentoHumano['correo'] = $_FORM['correo'] ?? '';
        $this->dataTalentoHumano['estado'] = $_FORM['estado'] ?? "Activo";
        $this->dataTalentoHumano['usuarios_id'] = $_FORM['usuarios_id'] ?? 0;

    }

    public function create() {
        try {
            if (!empty($this->dataTalentoHumano['documento']) && !Talentos::talentoHumanoRegistrado($this->dataTalentoHumano['documento'])) {
                $TalentoHumano = new Talentos ($this->dataTalentoHumano);
                if ($TalentoHumano->insert()) {
                    unset($_SESSION['frmCreateTalento']);
                    header("Location: ../../views/modules/talentos/index.php?respuesta=success&mensaje= Registrado");
                }
            } else {
                header("Location: ../../views/modules/talentos/create.php?respuesta=error&mensaje= Ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


        public function edit()
        {
            try {
                $TalentoHumano = new Talentos($this->dataTalentoHumano);
                if ($TalentoHumano->update()) {
                    unset($_SESSION['frmEditTalento']);
                    header("Location: ../../views/modules/talentos/show.php?id=" . $TalentoHumano->getId() . "&respuesta=success&mensaje= Actualizado");
                } else {
                    header("Location: ../../views/modules/talentos/edit.php?id=" . $TalentoHumano->getId() . "&respuesta=error&mensaje= No actualizado");
                }
            } catch (\Exception $e) {
                GeneralFunctions::logFile('Exception', $e, 'error');
                header("Location: ../../views/modules/talentos/edit.php?id=" . $TalentoHumano->getId() . "&respuesta=error&mensaje=" . $e);
            }
        }


        static public function searchForID(array $data)
    {
        try {
            $result = Talentos::searchForId($data['id']);
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
            $result = Talentos::getAll();
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

         static public function activate(int $id)
    {
        try {
            $ObjTalentoHumano = Talentos::searchForId($id);
            $ObjTalentoHumano->setEstado("Activo");
            if ($ObjTalentoHumano->update()) {
                header("Location: ../../views/modules/talentos/index.php");
            } else {
                header("Location: ../../views/modules/talentos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

         static public function inactivate(int $id)
    {
        try {
            $ObjTalentoHumano = Talentos::searchForId($id);
            $ObjTalentoHumano->setEstado("Inactiva");
            if ($ObjTalentoHumano->update()) {
                header("Location: ../../views/modules/talentos/index.php");
            } else {
                header("Location: ../../views/modules/talentos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }
    static public function selectTalentosHumanos(array $params = [])
    {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "talentos_id";
        $params['name'] = $params['name'] ?? "talentos_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrTalentosHumanos = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM talentos WHERE ";
            $arrTalentosHumanos = Talentos::search($base . ' ' . $params['where']);
        } else {
            $arrTalentosHumanos = Talentos::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrTalentosHumanos) && count($arrTalentosHumanos) > 0) {
            /* @var $arrTalentosHumanos Talentos[] */
            foreach ($arrTalentosHumanos as $talento)
                if (!TalentosController::talentoIsInArray($talento->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($talento != "") ? (($params['defaultValue'] == $talento->getId()) ? "selected" : "") : "") . " value='" . $talento->getId() . "'>"  . " # " .$talento->getId()  . " - " . $talento->getDocumento() . " - " . $talento->getNombres() . " " . $talento->getApellidos(). " - " . $talento->getEstado(). "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function talentoIsInArray($id, $ArrTalentosHumanos)
    {
        if (count($ArrTalentosHumanos) > 0) {
            foreach ($ArrTalentosHumanos as $Talento) {
                if ($Talento->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}
