<?php

namespace App\Models;


use App\Enums\Estado;


class Documentos extends AbstractDBConnection implements \App\Interfaces\Model
{
    private ?int $id;
    private string $talentoDocumento;
    private string $fechaNacimiento;
    private string $fechaExpedicion;
    private string $ruta;
    private Estado $estado;
    private int $talentos_id;


    /* Relaciones */
    private ?Talentos $talentos;

    /**
     * @param int|null $id
     * @param string $talentoDocumento
     * @param string $fechaNacimiento
     * @param string $fechaExpedicion
     * @param string $ruta
     * @param Estado $estado
     * @param int $talentos_id
     */
    public function __construct(array $documentos=[])
    {
        parent::__construct();
        $this->setId($documentos['id']?? null);
        $this->setTalentoDocumento($documentos['talentoDocumento'] ??'');
        $this->setFechaNacimiento($documentos['fechaNacimiento']??'');
        $this->setFechaExpedicion($documentos['fechaExpedicion']??'');
        $this->setRuta($documentos['ruta']??'');
        $this->setEstado ($documentos ['estado']?? Estado::ACTIVO);
        $this->setTalentosId($documentos['talentos_id']??0);
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
    public function getTalentoDocumento(): string
    {
        return $this->talentoDocumento;
    }

    /**
     * @param string $talentoDocumento
     */
    public function setTalentoDocumento(string $talentoDocumento): void
    {
        $this->talentoDocumento = $talentoDocumento;
    }

    /**
     * @return string
     */
    public function getFechaNacimiento(): string
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param string $fechaNacimiento
     */
    public function setFechaNacimiento(string $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    /**
     * @return string
     */
    public function getFechaExpedicion(): string
    {
        return $this->fechaExpedicion;
    }

    /**
     * @param string $fechaExpedicion
     */
    public function setFechaExpedicion(string $fechaExpedicion): void
    {
        $this->fechaExpedicion = $fechaExpedicion;
    }


    /**
     * @return string
     */
    public function getRuta(): string
    {
        return $this->ruta;
    }

    /**
     * @param string $ruta
     */
    public function setRuta(string $ruta): void
    {
        $this->ruta = $ruta;
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
     * Retorna el objeto talento correspondiente al Documento
     * @return Talentos|null
     */
    public function getTalentos(): ?Talentos
    {
        if(!empty($this->talentos_id)){
            $this->talento = Talentos::searchForId($this->talentos_id) ?? new Talentos();
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
                ':talentoDocumento' => $this->getTalentoDocumento(),
                ':fechaNacimiento' => $this->getFechaNacimiento(), //Y-m-d
                ':fechaExpedicion' => $this->getFechaExpedicion(), //Y-m-d
                ':ruta' => $this->getRuta(),
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
        $query ="INSERT INTO terminal.documentos VALUES (
           :id, :talentoDocumento,:fechaNacimiento, :fechaExpedicion, :ruta , :estado,:talentos_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query = "UPDATE terminal.documentos SET 
             talentoDocumento=:talentoDocumento, fechaNacimiento=:fechaNacimiento, fechaExpedicion=:fechaExpedicion,  ruta =:ruta,
              estado=:estado,talentos_id =:talentos_id
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
     * @return Documentos|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrDocumentos = array();
            $tmp = new Documentos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Documentos = new Documentos($valor);
                array_push($arrDocumentos, $Documentos);
                unset($Documentos);
            }
            return $arrDocumentos;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    /**
     * @param int $id
     * @return Documentos
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Documentos
    {

        try {
            if ($id > 0) {
                $tmpDocumento = new Documentos();
                $tmpDocumento->Connect();
                $getrow = $tmpDocumento->getRow("SELECT * FROM terminal.documentos WHERE id =?", array($id));
                $tmpDocumento->Disconnect();
                return ($getrow) ? new Documentos($getrow) : null;
            } else {
                throw new Exception('Id del Egreso Invalido');
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
        return Documentos::search("SELECT * FROM terminal.documentos");
    }


    /**
     * @param $talentoDocumento
     * @return bool
     * @throws Exception
     */

    public static function documentoRegistrado($talentoDocumento): bool
    {
        $result = Documentos::search("SELECT * FROM terminal.documentos where talentoDocumento = '" . $talentoDocumento. "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function __toString(): string
    {
        return "talentoDocumento: $this->talentoDocumento,
                fechaNacimiento:$this->fechaNacimiento,
                fechaExpedicion:$this->fechaExpedicion,
                ruta: $this->ruta,
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
            'talentoDocumento'=> $this->getTalentoDocumento(),
            'fechaNacimiento'=> $this->getFechaNacimiento(),
            'fechaExpedicion'=> $this->getFechaExpedicion(),
            'ruta'=> $this->getRuta(),
            'talentos'=> $this->getTalentos()->jsonSerialize(),
            'estado'=>$this->getEstado(),

        ];
    }


}