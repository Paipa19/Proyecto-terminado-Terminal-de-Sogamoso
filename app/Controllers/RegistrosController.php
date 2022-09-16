<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Registros;

class RegistrosController
{


    private array $dataHistoriasLaborales;

    public function  __construct(array $_FORM){

        $this->dataHistoriasLaborales =array();
        $this->dataHistoriasLaborales['id']=$_FORM['id']?? NULL;
        $this->dataHistoriasLaborales ['numeroGaveta']=$_FORM['numeroGaveta']?? '';
        $this->dataHistoriasLaborales ['numeroCarpetas']=$_FORM['numeroCarpetas']?? '';
        $this->dataHistoriasLaborales ['numeroFolios']=$_FORM['numeroFolios']?? '';
        $this->dataHistoriasLaborales ['documento']=$_FORM['documento']?? '';
        $this->dataHistoriasLaborales ['numeroArchivador']=$_FORM['numeroArchivador']?? '';
        $this->dataHistoriasLaborales ['nombre']=$_FORM['nombre']?? '';
        $this->dataHistoriasLaborales ['apellido']=$_FORM['apellido']?? '';
        $this->dataHistoriasLaborales ['cargo']=$_FORM['cargo']?? '';
        $this->dataHistoriasLaborales ['tipoVinculacion']=$_FORM['tipoVinculacion']?? '';
        $this->dataHistoriasLaborales ['estado']=$_FORM['estado'] ?? 'Activo';
        $this->dataHistoriasLaborales ['usuarios_id']=$_FORM['usuarios_id']?? 0;

    }

    public function create()
    {
        try {
            if (!empty($this->dataHistoriasLaborales['documento']) && !Registros::historiaLaboralRegistrado($this->dataHistoriasLaborales['documento'])) {
                $HistoriaLaboral = new Registros ($this->dataHistoriasLaborales);
                if ($HistoriaLaboral->insert()) {
                    unset($_SESSION['frmCreateRegistro']);
                    header("Location: ../../views/modules/registros/index.php?respuesta=success&mensaje= Registrado");
                }
            } else {
                header("Location: ../../views/modules/registros/create.php?respuesta=error&mensaje= Ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }




    public function edit()
    {
        try {
            if($_SESSION['UserInSession']['rol'] == "Auxiliar") {
                $result = Registros::searchForId($this->dataHistoriasLaborales['id']);
                $this->dataHistoriasLaborales[$result->getEstado()];
            }
            $HistoriaLaboral = new Registros($this->dataHistoriasLaborales);
            if($HistoriaLaboral->update()){
                unset($_SESSION['frmEditRegistro']);
                header("Location: ../../views/modules/registros/show.php?id=" . $HistoriaLaboral->getId() . "&respuesta=success&mensaje= Actualizado");
            }else{
                header("Location: ../../views/modules/registros/edit.php?id=" . $HistoriaLaboral->getId() . "&respuesta=error&mensaje= No actualizado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            header("Location: ../../views/modules/registros/edit.php?id=" . $HistoriaLaboral->getId() . "&respuesta=error&mensaje=".$e);
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Registros::searchForId($data['id']);
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
            $query_where = '';
            if($_SESSION['UserInSession']['rol'] == "Auxiliar") $query_where = " WHERE estado = 'Inactiva'";
            $result = Registros::getAll($query_where);
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
            $ObjHistoriaLaboral = Registros::searchForId($id);
            $ObjHistoriaLaboral->setEstado("Activo");
            if($ObjHistoriaLaboral->update()){
                header("Location: ../../views/modules/registros/index.php");
            }else{
                header("Location: ../../views/modules/registros/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjHistoriaLaboral = Registros::searchForId($id);
            $ObjHistoriaLaboral->setEstado("Inactiva");
            if ($ObjHistoriaLaboral->update()) {
                header("Location: ../../views/modules/registros/index.php");
            } else {
                header("Location: ../../views/moduleshistoriasLaborales/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectHistoriasLaborales(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "HistoriaLaboral_id";
        $params['name'] = $params['name'] ?? "HistoriaLaboral_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrHistoriasLaborales = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM historiaslaborales WHERE ";
            $arrHistoriasLaborales = Registros::search($base . ' ' . $params['where']);
        } else {
            $arrHistoriasLaborales = Registros::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrHistoriasLaborales) && count($arrHistoriasLaborales) > 0) {
            /* @var $arrHistoriasLaborales Registros[] */
            foreach ($arrHistoriasLaborales as $historiaLaboral)
                if (!RegistrosController::historiaLaboralIsInArray($historiaLaboral->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($historiaLaboral != "") ? (($params['defaultValue'] == $historiaLaboral->getId()) ? "selected" : "") : "") . " value='" . $historiaLaboral->getId() . "'>"."# " . $historiaLaboral->getUsuariosId() ."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function historiaLaboralIsInArray($id, $ArrHistoriasLaborales)
    {
        if (count($ArrHistoriasLaborales) > 0) {
            foreach ($ArrHistoriasLaborales as $historiaLaboral) {
                if ($historiaLaboral->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}

























