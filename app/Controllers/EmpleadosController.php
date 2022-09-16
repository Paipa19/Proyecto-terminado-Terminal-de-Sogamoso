<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Empleados;
use Carbon\Carbon;


class EmpleadosController{

    private array $dataEmpleado;

    public function  __construct(array $_FORM){

        $this->dataEmpleado =array();
        $this->dataEmpleado ['id']=$_FORM['id']?? NULL;
        $this->dataEmpleado ['tipoContrato']=$_FORM['tipoContrato']?? '';
        $this->dataEmpleado ['documento']=$_FORM['documento']?? '';
        $this->dataEmpleado ['numeroContrato']=$_FORM['numeroContrato']?? '';
        $this->dataEmpleado ['inicioContrato']=$_FORM['inicioContrato']?? '';
        $this->dataEmpleado ['finContrato']=$_FORM['finContrato']?? '';
        $this->dataEmpleado ['cargo']=$_FORM['cargo']?? '';
        $this->dataEmpleado ['prorroga1']=$_FORM['prorroga1']?? '';
        $this->dataEmpleado ['prorroga2']=$_FORM['prorroga2']?? '';
        $this->dataEmpleado ['prorroga3']=$_FORM['prorroga3']?? '';
        $this->dataEmpleado ['prorroga4']=$_FORM['prorroga4']?? '';
        $this->dataEmpleado ['estado']=$_FORM['estado'] ?? 'Activo';
        $this->dataEmpleado ['talentos_id']=$_FORM['talentos_id']?? 0;

    }

    public function create()
    {
        try {
            if (!empty($this->dataEmpleado['documento']) && !Empleados::empleadoRegistrado($this->dataEmpleado['documento'])) {
                $Empleado = new Empleados ($this->dataEmpleado);
                if ( $Empleado->insert()) {
                    unset($_SESSION['frmCreateEmpleado']);
                    header("Location: ../../views/modules/empleados/index.php?respuesta=success&mensaje= Registrado");
                }
            } else {
                header("Location: ../../views/modules/empleados/create.php?respuesta=error&mensaje= Ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }




    public function edit()
    {
        try {
            $empleado = new Empleados($this->dataEmpleado);
            if($empleado->update()){
                unset($_SESSION['frmEditEmpleado']);
            }
            header("Location: ../../views/modules/empleados/show.php?id=" . $empleado->getId() . "&respuesta=success&mensaje= Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            //header("Location: ../../views/modules/archivos/edit.php?respuesta=error");
        }
    }


    static public function searchForID (array $data){
        try {
            $result = Empleados::searchForId($data['id']);
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
            $result = Empleados::getAll();
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

    static public function activate(int $id)
    {
        try {
            $ObjEmpleado= Empleados::searchForId($id);
            $ObjEmpleado->setEstado("Activo");
            if ($ObjEmpleado->update()) {
                header("Location: ../../views/modules/empleados/index.php");
            } else {
                header("Location: ../../views/modules/empleados/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjEmpleado = Empleados::searchForId($id);
            $ObjEmpleado->setEstado("Inactiva");
            if ($ObjEmpleado->update()) {
                header("Location: ../../views/modules/empleados/index.php");
            } else {
                header("Location: ../../views/modules/empleados/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }


    static public function selectEmpleado(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "empleado_id";
        $params['name'] = $params['name'] ?? "empleado_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrEmpleados = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM empleado WHERE ";
            $arrEmpleados = empleados::search($base . ' ' . $params['where']);
        } else {
            $arrEmpleados = Empleados::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrEmpleados) && count($arrEmpleados) > 0) {
            /* @var $arrEmpleados Empleados[] */
            foreach ($arrEmpleados as $empleado)
                if (!EmpleadosController::empleadoIsInArray($empleado->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($empleado != "") ? (($params['defaultValue'] == $empleado->getId()) ? "selected" : "") : "") . " value='" . $empleado->getId() . "'>". $empleado->getId() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function empleadoIsInArray($id, $ArrEmpleados)
    {
        if (count($ArrEmpleados) > 0) {
            foreach ($ArrEmpleados as $Empleado) {
                if ($Empleado->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }

}