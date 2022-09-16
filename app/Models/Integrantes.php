<?php

namespace App\Models;

use App\Enums\Estado;
use App\Interfaces\Model;

class Integrantes extends AbstractDBConnection implements \App\Interfaces\Model
{
    private ?int $id;
    private string $documentoTalento;
    private string $tipoDocumento;
    private string $documentoFamiliar;
    private string $nombreFamiliar;
    private string $apellidoFamiliar;
    private string $telefono;
    private string $parentesco;
    private Estado $estado;
    private int $talentos_id;

    /* Relaciones */
    private ?Talentos $talentos;

    /**
     * @param int|null $id
     * @param string $documentoTalento
     * @param string $tipoDocumento
     * @param int $documentoFamiliar
     * @param string $nombreFamiliar
     * @param string $apellidoFamiliar
     * @param int $telefono
     * @param string $parentesco
     * @param Estado $estado
     * @param int $talentos_id
     */
    public function __construct(array $integrantes=[])
    {
        parent::__construct();
        $this->setId($integrantes['id']?? null);
        $this->setDocumentoTalento($integrantes['documentoTalento']??'');
        $this->setTipoDocumento($integrantes['tipoDocumento'] ?? '');
        $this->setDocumentoFamiliar ($integrantes['documentoFamiliar']??'');
        $this->setNombreFamiliar ($integrantes['nombreFamiliar']??'');
        $this->setApellidoFamiliar ($integrantes['apellidoFamiliar']??'');
        $this->setTelefono ($integrantes['telefono']??'');
        $this->setParentesco ($integrantes['parentesco']??'');
        $this->setEstado ($integrantes['estado']?? Estado::ACTIVO);
        $this->setTalentosId($integrantes['talentos_id'] ?? 0);
    }

    public function __destruct()
    {
        if ($this->isConnected()) {
            $this->Disconnect();
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDocumentoTalento(): string
    {
        return $this->documentoTalento;
    }

    /**
     * @param string $documentoTalento
     */
    public function setDocumentoTalento(string $documentoTalento): void
    {
        $this->documentoTalento = $documentoTalento;
    }


    /**
     * @return string
     */
    public function getTipoDocumento(): string
    {
        return $this->tipoDocumento;
    }

    /**
     * @param string $tipoDocumento
     */
    public function setTipoDocumento(string $tipoDocumento): void
    {
        $this->tipoDocumento = $tipoDocumento;
    }

    /**
     * @return string
     */
    public function getDocumentoFamiliar(): string
    {
        return $this->documentoFamiliar;
    }

    /**
     * @param string $documentoFamiliar
     */
    public function setDocumentoFamiliar(string $documentoFamiliar): void
    {
        $this->documentoFamiliar = $documentoFamiliar;
    }

    /**
     * @return string
     */
    public function getNombreFamiliar(): string
    {
        return $this->nombreFamiliar;
    }

    /**
     * @param string $nombreFamiliar
     */
    public function setNombreFamiliar(string $nombreFamiliar): void
    {
        $this->nombreFamiliar = $nombreFamiliar;
    }

    /**
     * @return string
     */
    public function getApellidoFamiliar(): string
    {
        return $this->apellidoFamiliar;
    }

    /**
     * @param string $apellidoFamiliar
     */
    public function setApellidoFamiliar(string $apellidoFamiliar): void
    {
        $this->apellidoFamiliar = $apellidoFamiliar;
    }

    /**
     * @return string
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }


    /**
     * @return string
     */
    public function getParentesco(): string
    {
        return $this->parentesco;
    }

    /**
     * @param string $parentesco
     */
    public function setParentesco(string $parentesco): void
    {
        $this->parentesco = $parentesco;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado->toString();
    }

    /**
     * @param Estado|null $estado
     */
    public function setEstado(null|string|Estado $estado): void
    {
        if(is_string($estado)){
            $this->estado = Estado::from($estado);
        }else{
            $this->estado = $estado;
        }
    }

    /**
     * @return int
     */
    public function getTalentosId(): int
    {
        return $this->talentos_id;
    }

    /**
     * @param int $talentos_id
     */
    public function setTalentosId(int $talentos_id): void
    {
        $this->talentos_id = $talentos_id;
    }


    /**
     * Retorna el objeto del talento humano correspondiente
     * @return Talentos|null
     */
    public function getTalentos(): ?Talentos
    {
        if(!empty($this->talentos_id)){
            $this->talento= Talentos::searchForId($this->talentos_id) ?? new Talentos();
            return $this->talento;
        }
        return NULL;
    }
    /**
     * @param Talentos|null $talentos
     */
    public function setTalentos(?Talentos $talentos): void
    {
        $this->talentos = $talentos;
    }



    protected function save(string $query): ?bool
    {
        {
            $arrData = [
                ':id' => $this->getId(),
                ':documentoTalento'=> $this->getDocumentoTalento(),
                ':tipoDocumento' => $this->getTipoDocumento(),
                ':documentoFamiliar' => $this->getDocumentoFamiliar(),
                ':nombreFamiliar' => $this->getNombreFamiliar(),
                ':apellidoFamiliar' => $this->getApellidoFamiliar(),
                ':telefono' => $this->getTelefono(),
                ':parentesco' => $this->getParentesco(),
                ':estado' => $this->getEstado(),
                ':talentos_id' => $this->getTalentosId(),
            ];

            $this->Connect();
            $result = $this->insertRow($query, $arrData);
            $this->Disconnect();
            return $result;
        }

    }

    /**
     * @return bool|null
     */
    function insert(): ?bool
    {
        $query ="INSERT INTO terminal.integrantes VALUES (
           :id,:documentoTalento,:tipoDocumento, :documentoFamiliar, :nombreFamiliar, :apellidoFamiliar, :telefono, :parentesco, :estado,:talentos_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query = "UPDATE terminal.integrantes SET 
             documentoTalento=:documentoTalento, tipoDocumento=:tipoDocumento, documentoFamiliar=:documentoFamiliar, nombreFamiliar =:nombreFamiliar, 
              apellidoFamiliar =:apellidoFamiliar, telefono=:telefono, parentesco=:parentesco, 
              estado=:estado, talentos_id =:talentos_id
                 WHERE id = :id";
        return $this->save($query);

    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setEstado("Inactiva");
        return $this->update();
    }

    /**
     * @param $query
     * @return Integrantes|array
     * @throws Exception
     */
    public static function search($query): ?array
    { 
        try {
            $arrIntegrantes = array();
            $tmp = new Integrantes();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Integrante = new Integrantes($valor);
                array_push($arrIntegrantes, $Integrante);
                unset($Integrantes);
            }
            return $arrIntegrantes;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }


    /**
     * @param int $id
     * @return Integrantes
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Integrantes
    {

        try {
            if ($id > 0) {
                $tmpIntegrante = new Integrantes();
                $tmpIntegrante->Connect();
                $getrow = $tmpIntegrante->getRow("SELECT * FROM terminal.integrantes WHERE id =?", array($id));
                $tmpIntegrante->Disconnect();
                return ($getrow) ? new Integrantes($getrow) : null;
            } else {
                throw new Exception('Id del Integrante Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exeption', $e, 'error');
        }
        return null;
    }


    /**
     * @return array
     * @throws Exception
     */
    public static function getAll(): ?array
    {
        return Integrantes::search("SELECT * FROM terminal.integrantes");
    }


    /**
     * @param $documentoFamiliar
     * @return bool
     * @throws Exception
     */

    public static function integranteRegistrado($documentoFamiliar): bool
    {
        $result = Integrantes::search("SELECT * FROM terminal.integrantes where documentoFamiliar = '" . $documentoFamiliar. "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }



    public function __toString(): string
    {
        return "documentoTalento: $this->documentoTalento,
                tipoDocumento:$this->tipoDocumento,
                documentoFamiliar:$this->documentoFamiliar,
                nombreFamiliar: $this->nombreFamiliar,
                apellidoFamiliar: $this->apellidoFamiliar,
                telefono: $this->telefono,
                parentesco: $this->parentesco,
                talentos: $this->talentos_id,
                estado: ".$this->getEstado();
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'documentoTalento'=>$this->getDocumentoTalento(),
            'tipoDocumento'=> $this->getTipoDocumento(),
            'documentoFamiliar'=> $this->getDocumentoFamiliar(),
            'nombreFamiliar' => $this->getNombreFamiliar(),
            'apellidoFamiliar'=> $this->getApellidoFamiliar(),
            'telefono'=>$this->getTelefono(),
             'parentesco'=> $this->getParentesco(),
             'estado'=>$this->getEstado(),
             'talentos'=> $this->getTalentos()->jsonSerialize(),


        ];
    }

}