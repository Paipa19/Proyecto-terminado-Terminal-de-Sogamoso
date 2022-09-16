<?php

namespace App\Models;

use App\Enums\Estado;
use App\Interfaces\Model;


class Seguros extends AbstractDBConnection implements \App\Interfaces\Model
{

    private ?int $id;
    private string $documento;
    private string $salud;
    private string $pension;
    private string $riesgosLabores;
    private Estado $estado;
    private int $talentos_id;

    //Relaciones
    private ?Talentos $talentos;

    /**
     * @param int|null $id
     * @param string $documento
     * @param string $salud
     * @param string $pension
     * @param string $riesgosLabores
     * @param Estado $Estado
     * @param int $talentos_id
     */
    public function __construct(array $Seguros=[])
    {
        parent::__construct();
        $this->setId($Seguros['id'] ?? null);
        $this->setDocumento($Seguros['documento'] ?? '');
        $this->setSalud($Seguros['salud'] ?? '');
        $this->setPension($Seguros['pension'] ?? '');
        $this->setRiesgosLabores($Seguros['riegosLaborales'] ?? '');
        $this->setEstado($Seguros['estado'] ?? Estado::ACTIVO);
        $this->setTalentosId($Seguros['talentos_id'] ?? 0);
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
    public function getDocumento(): string
    {
        return $this->documento;
    }

    /**
     * @param string $documento
     */
    public function setDocumento(string $documento): void
    {
        $this->documento = $documento;
    }


    /**
     * @return string
     */
    public function getSalud(): string
    {
        return $this->salud;
    }

    /**
     * @param string $salud
     */
    public function setSalud(string $salud): void
    {
        $this->salud = $salud;
    }

    /**
     * @return string
     */
    public function getPension(): string
    {
        return $this->pension;
    }

    /**
     * @param string $pension
     */
    public function setPension(string $pension): void
    {
        $this->pension = $pension;
    }

    /**
     * @return string
     */
    public function getRiesgosLabores(): string
    {
        return $this->riesgosLabores;
    }

    /**
     * @param string $riesgosLabores
     */
    public function setRiesgosLabores(string $riesgosLabores): void
    {
        $this->riesgosLabores = $riesgosLabores;
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
                ':documento' =>$this->getDocumento(),
                ':salud' => $this->getSalud(),
                ':pension' => $this->getPension(),
                ':riegosLaborales' => $this->getRiesgosLabores(),
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
        $query = "INSERT INTO terminal.seguros VALUES (
       :id, :documento,:salud,:pension,:riegosLaborales, :estado,:talentos_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query = "UPDATE terminal.seguros SET 
       documento=:documento, salud=:salud,pension=:pension, riegosLaborales=:riegosLaborales,
        estado=:estado,talentos_id=:talentos_id
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
     * @return Seguros|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrSeguros = array();
            $tmp = new Seguros();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Seguro = new Seguros($valor);
                array_push($arrSeguros, $Seguro);
                unset($Seguros);
            }
            return $arrSeguros;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    /**
     * @param int $id
     * @return Seguros
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Seguros
    {
        try {
            if ($id > 0) {
                $tmpSeguro = new Seguros();
                $tmpSeguro->Connect();
                $getrow = $tmpSeguro->getRow("SELECT * FROM terminal.seguros WHERE id =?", array($id));
                $tmpSeguro->Disconnect();
                return ($getrow) ? new Seguros($getrow) : null;
            } else {
                throw new Exception('Id de afiliación Invalido');
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
        return Seguros::search("SELECT * FROM terminal.seguros");
    }


    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */

    public static function seguroRegistrado($documento): bool
    {
        $result = Seguros::search("SELECT * FROM terminal.seguros where documento = '" . $documento. "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function __toString(): string
    {
        return "documento: $this->documento,
                salud: $this->salud,
                pension: $this->pension,
                riegosLaborales: $this->riesgosLabores,
                talentos:$this->talentos_id,
                estado: ".$this->getEstado();

    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'documento'=> $this->getDocumento(),
            'salud' => $this->getSalud(),
            'pension' => $this->getPension(),
            'riegosLaborales' => $this->getRiesgosLabores(),
            'estado' => $this->getEstado(),
            'talentos' => $this->getTalentosId()->jsonSerialize(),
        ];
    }


}