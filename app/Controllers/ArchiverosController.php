<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Archiveros;

class ArchiverosController
{

    private array $dataArchivero;

    public function  __construct(array $_FORM){

        $this->dataArchivero =array();
        $this->dataArchivero ['id']=$_FORM['id']?? NULL;
        $this->dataArchivero ['numBoletin']=$_FORM['numBoletin']??'';
        $this->dataArchivero ['numFolios']=$_FORM['numFolios']?? '';
        $this->dataArchivero ['numRecibo']=$_FORM['numRecibo']?? '';
        $this->dataArchivero ['numEstante']=$_FORM['numEstante']?? '';
        $this->dataArchivero ['nivelEstante']=$_FORM['nivelEstante']?? '';
        $this->dataArchivero ['numCaja']=$_FORM['numCaja']?? '';
        $this->dataArchivero ['numCarpeta']=$_FORM['numCarpeta']?? '';
        $this->dataArchivero ['ingresos_id']=$_FORM['ingresos_id']?? 0;


    }


    public function create() {
        try {
            $Archivero = new Archiveros($this->dataArchivero);
            if ($Archivero->insert()) {
                unset($_SESSION['frmCreateArchivero']);
                $Archivero->Connect();
                $id = $Archivero->getLastId('archiveros');
                $Archivero->Disconnect();
                header("Location: ../../views/modules/archiveros/index.php?id=" . $id . "&respuesta=success&mensaje=  Registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            //header("Location: ../../views/modules/archiveros/create.php?respuesta=error");
        }
    }


    public function edit()
    {
        try {
            $archivero = new Archiveros($this->dataArchivero);
            if($archivero->update()){
                unset($_SESSION['frmEditArchivero']);
            }
            header("Location: ../../views/modules/archiveros/show.php?id=" . $archivero->getId() . "&respuesta=success&mensaje= Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            //header("Location: ../../views/modules/archiveros/edit.php?respuesta=error");
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Archiveros::searchForId($data['id']);
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
            $result = Archiveros::getAll();
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


    static public function selectArchiveros(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "archivero_id";
        $params['name'] = $params['name'] ?? "archivero_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrArchiveros = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM archiveros WHERE ";
            $arrArchiveros = Archiveros::search($base . ' ' . $params['where']);
        } else {
            $arrArchiveros = Archiveros::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrArchiveros) && count($arrArchiveros) > 0) {
            /* @var $arrArchiveros Archiveros[] */
            foreach ($arrArchiveros as $archivero)
                if (!ArchiverosController::archiveroIsInArray($archivero->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($archivero != "") ? (($params['defaultValue'] == $archivero->getId()) ? "selected" : "") : "") . " value='" . $archivero->getId() . "'>"."N° de Folios : ". $archivero->getNumFolios() . " - "."N° de Estante : ". $archivero->getNumEstante() . " - "."Nivel de Estante : ". $archivero->getNivelEstante() . " - "."N° de Caja : ". $archivero->getNumCaja() . " - "."N° de Carpeta : ". $archivero->getNumCarpeta() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function archiveroIsInArray($id, $ArrArchiveros)
    {
        if (count($ArrArchiveros) > 0) {
            foreach ($ArrArchiveros as $Archivero) {
                if ($Archivero->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }

}




