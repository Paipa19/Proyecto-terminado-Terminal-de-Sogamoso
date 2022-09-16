<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Documentos;


class DocumentosController
{

    private array $dataDocumento;

    public function __construct(array $_FORM)
    {

        $this->dataDocumento = array();
        $this->dataDocumento ['id'] = $_FORM['id'] ?? NULL;
        $this->dataDocumento ['talentoDocumento'] = $_FORM['talentoDocumento'] ??'';
        $this->dataDocumento ['fechaNacimiento'] = $_FORM['fechaNacimiento'] ?? '';
        $this->dataDocumento ['fechaExpedicion'] = $_FORM['fechaExpedicion'] ?? '';
        $this->dataDocumento ['ruta'] = $_FORM['name_documento'] ?? '';
        $this->dataDocumento ['estado'] = $_FORM['estado'] ?? 'Activo';
        $this->dataDocumento ['talentos_id'] = $_FORM['talentos_id'] ?? 0;

    }

    
    public function create($withFiles)
    {
        try {
            if (!empty($this->dataDocumento['talentoDocumento']) && !Documentos::documentoRegistrado($this->dataDocumento['talentoDocumento'])) {
            if (!empty($withFiles) && $withFiles['documento']['error'] === 0) {
                $documentoTalento = $withFiles['documento'];
                $resultUpload = GeneralFunctions::subirArchivo($documentoTalento, "views/public/uploadFiles/documents/");
                if ($resultUpload != false) {
                    $this->dataDocumento['ruta'] = $resultUpload;
                }
            }
            $Documento = new Documentos ($this->dataDocumento);
            if ($Documento->insert()) {
                unset($_SESSION['frmDocusmento']);
                header("Location: ../../views/modules/documentos/index.php?respuesta=success&mensaje=Documento se registro Correctamente");
            }
            } else {
                header("Location: ../../views/modules/documentos/create.php?respuesta=error&mensaje= ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    public function edit($withFiles = null)
    {
        try {
            if (!empty($withFiles)) {
                $rutaDocumento = $withFiles['documento'];
                if ($rutaDocumento['error'] == 0) { //Si el documento se selecciono correctamente
                    $resultUpload = GeneralFunctions::subirArchivo($rutaDocumento, "views/public/uploadFiles/documents/");
                    if ($resultUpload != false) {
                        GeneralFunctions::eliminarArchivo("views/public/uploadFiles/documents/" . $this->dataDocumento['ruta']);
                        $this->dataDocumento['ruta'] = $resultUpload;
                    }
                }
            }
            $documento = new Documentos($this->dataDocumento);
            if ($documento->update()) {
                unset($_SESSION['frmDocumento']);
            }
            header("Location: ../../views/modules/documentos/show.php?id=" . $documento->getId() . "&respuesta=success&mensaje=Documento Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function search(array $data)
    {
        try {
            $result =  Documentos::search($data['query']);
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

    static public function searchForID(array $data)
    {
        try {
            $result = Documentos::searchForId($data['id']);
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
            $result = Documentos::getAll();
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
            $ObjDocumento = Documentos::searchForId($id);
            $ObjDocumento->setEstado("Activo");
            if ($ObjDocumento->update()) {
                header("Location: ../../views/modules/documentos/index.php");
            } else {
                header("Location: ../../views/modules/documentos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjDocumento = Documentos::searchForId($id);
            $ObjDocumento->setEstado("Inactiva");
            if ($ObjDocumento->update()) {
                header("Location: ../../views/modules/documentos/index.php");
            } else {
                header("Location: ../../views/modules/documentos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function selectDocumento(array $params = [])
    {
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "documento_id";
        $params['name'] = $params['name'] ?? "documento_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrDocumento = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM documentos WHERE ";
            $arrDocumento = Documentos::search($base . $params['where']);
        } else {
            $arrDocumento = Documentos::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrDocumento) > 0) {
            /* @var $arrDocumento Documentos[] */
            foreach ($arrDocumento as $documento)
                if (!DocumentosController::documentoIsInArray($documento->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($documento != "") ? (($params['defaultValue'] == $documento->getId()) ? "selected" : "") : "") . " value='" . $documento->getId() . "'>" . $documento->getNombre() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function documentoIsInArray($idDocumento, $ArrDocumentos)
    {
        if (count($ArrDocumentos) > 0) {
            foreach ($ArrDocumentos as $Documento) {
                if ($Documento->getId() == $idDocumento) {
                    return true;
                }
            }
        }
        return false;
    }
}