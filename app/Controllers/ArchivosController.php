<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Archivos;

class ArchivosController
{


    private array $dataArchivo;

    public function  __construct(array $_FORM){

        $this->dataArchivo =array();
        $this->dataArchivo['id']=$_FORM['id']?? NULL;
        $this->dataArchivo ['numFolios']=$_FORM['numFolios']?? '';
        $this->dataArchivo ['numEstante']=$_FORM['numEstante']?? '';
        $this->dataArchivo ['nivelEstante']=$_FORM['nivelEstante']?? '';
        $this->dataArchivo ['numCaja']=$_FORM['numCaja']?? '';
        $this->dataArchivo ['numCarpeta']=$_FORM['numCarpeta']?? '';
        $this->dataArchivo ['numComprobante']=$_FORM['numComprobante']?? '';
        $this->dataArchivo ['numeroIdentificacion']=$_FORM['numeroIdentificacion']?? '';
        $this->dataArchivo ['egresos_id']=$_FORM['egresos_id']??0;

    }

    public function create() {
        try {
            $Archivo = new Archivos($this->dataArchivo);
            if ($Archivo->insert()) {
                unset($_SESSION['frmCreateArchivo']);
                $Archivo->Connect();
                $id = $Archivo->getLastId('archivos');
                $Archivo->Disconnect();
                header("Location: ../../views/modules/archivos/index.php?id=" . $id . "&respuesta=success&mensaje=  Registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            //header("Location: ../../views/modules/archivos/create.php?respuesta=error");
        }
    }


    public function edit()
    {
        try {
            $archivo = new Archivos($this->dataArchivo);
            if($archivo->update()){
                unset($_SESSION['frmEditArchivo']);
            }
            header("Location: ../../views/modules/archivos/show.php?id=" . $archivo->getId() . "&respuesta=success&mensaje= Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            //header("Location: ../../views/modules/archivos/edit.php?respuesta=error");
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Archivos::searchForId($data['id']);
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
            $result = Archivos::getAll();
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




    static public function selectArchivo (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "archivo_id";
        $params['name'] = $params['name'] ?? "archivo_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrAchivos = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM archivos WHERE ";
            $arrAchivos= archivos::search($base.$params['where']);
        }else{
            $arrAchivos = archivos::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(is_array($arrAchivos) && count($arrAchivos) > 0){
            /* @var $arrArchivos Archivos */
            foreach ($arrAchivos as $archivo)
                if (!ArchivosController::archivoIsInArray($archivo->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($archivo != "") ? (($params['defaultValue'] == $archivo->getId()) ? "selected" : "" ) : "")." value='".$archivo->getId()."'>".$archivo->getNumCaja()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function archivoIsInArray($id, $ArrArchivos){
        if(count($ArrArchivos) > 0){
            foreach ($ArrArchivos as $Archivo){
                if($Archivo->getId() == $id){
                    return true;
                }
            }
        }
        return false;
    }

}





















