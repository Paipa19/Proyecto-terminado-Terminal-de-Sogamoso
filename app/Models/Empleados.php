<?php

namespace App\Models;

use App\Enums\Estado;
use App\Interfaces\Model;


class Empleados extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $tipoContrato;
    private string$documento;
    private string $numeroContrato;
    private string $inicioContrato;
    private string $finContrato;
    private string $cargo;
    private string $prorroga1;
    private string $prorroga2;
    private string $prorroga3;
    private string $prorroga4;
    private Estado $estado;
    private int $talentos_id;

    //Relaciones
    private ?Talentos $talentos;

    /**
     * @param int|null $id
     * @param string $tipoContrato
     * @param string $Documento
     * @param string $numeroContrato
     * @param string $inicioContrato
     * @param string $finContrato
     * @param string $Cargo
     * @param string $prorroga1
     * @param string $prorroga2
     * @param string $prorroga3
     * @param string $prorroga4
     * @param Estado $estado
     * @param int $talentos_id
     */
    public function __construct(array $empleados = [])
    {
        parent::__construct();
        $this->setId($empleados['id'] ?? null);
        $this->setTipoContrato($empleados['tipoContrato'] ??'');
        $this->setDocumento($empleados['documento'] ??'');
        $this->setNumeroContrato($empleados['numeroContrato'] ??'');
        $this->setInicioContrato($empleados['inicioContrato'] ?? '');
        $this->setFinContrato($empleados['finContrato'] ?? '');
        $this->setCargo($empleados['cargo'] ?? '');
        $this->setProrroga1($empleados['prorroga1'] ?? '');
        $this->setProrroga2($empleados['prorroga2'] ?? '');
        $this->setProrroga3($empleados['prorroga3'] ?? '');
        $this->setProrroga4($empleados['prorroga4'] ?? '');
        $this->setEstado($empleados['estado'] ?? Estado::ACTIVO);
        $this->setTalentosId($empleados['talentos_id'] ?? 0);
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
    public function getTipoContrato(): string
    {
        return $this->tipoContrato;
    }

    /**
     * @param string $tipoContrato
     */
    public function setTipoContrato(string $tipoContrato): void
    {
        $this->tipoContrato = $tipoContrato;
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
    public function getNumeroContrato(): string
    {
        return $this->numeroContrato;
    }

    /**
     * @param string $numeroContrato
     */
    public function setNumeroContrato(string $numeroContrato): void
    {
        $this->numeroContrato = $numeroContrato;
    }

    /**
     * @return string
     */
    public function getInicioContrato(): string
    {
        return $this->inicioContrato;
    }

    /**
     * @param string $inicioContrato
     */
    public function setInicioContrato(string $inicioContrato): void
    {
        $this->inicioContrato = $inicioContrato;
    }


    /**
     * @return string
     */
    public function getFinContrato(): string
    {
        return $this->finContrato;
    }

    /**
     * @param string $finContrato
     */
    public function setFinContrato(string $finContrato): void
    {
        $this->finContrato = $finContrato;
    }


    /**
     * @return string
     */
    public function getCargo(): string
    {
        return $this->cargo;
    }

    /**
     * @param string $cargo
     */
    public function setCargo(string $cargo): void
    {
        $this->cargo = $cargo;
    }


    /**
     * @return string
     */
    public function getProrroga1(): string
    {
        return $this->prorroga1;
    }

    /**
     * @param string $prorroga1
     */
    public function setProrroga1(string $prorroga1): void
    {
        $this->prorroga1 = $prorroga1;
    }

    /**
     * @return string
     */
    public function getProrroga2(): string
    {
        return $this->prorroga2;
    }

    /**
     * @param string $prorroga2
     */
    public function setProrroga2(string $prorroga2): void
    {
        $this->prorroga2 = $prorroga2;
    }

    /**
     * @return string
     */
    public function getProrroga3(): string
    {
        return $this->prorroga3;
    }

    /**
     * @param string $prorroga3
     */
    public function setProrroga3(string $prorroga3): void
    {
        $this->prorroga3 = $prorroga3;
    }

    /**
     * @return string
     */
    public function getProrroga4(): string
    {
        return $this->prorroga4;
    }

    /**
     * @param string $prorroga4
     */
    public function setProrroga4(string $prorroga4): void
    {
        $this->prorroga4 = $prorroga4;
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
                ':tipoContrato'=>$this->getTipoContrato(),
                ':documento'=>$this->getDocumento(),
                ':numeroContrato' => $this->getNumeroContrato(),
                ':inicioContrato' => $this->getInicioContrato(),
                ':finContrato' => $this->getFinContrato(),
                ':cargo' => $this->getCargo(),
                ':prorroga1' => $this->getProrroga1(),
                ':prorroga2' => $this->getProrroga2(),
                ':prorroga3' => $this->getProrroga3(),
                ':prorroga4' => $this->getProrroga4(),
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
        $query = "INSERT INTO terminal.empleado VALUES (
       :id,:tipoContrato,:documento,:numeroContrato,:inicioContrato,:finContrato,:cargo,:prorroga1,:prorroga2,:prorroga3,:prorroga4,:estado,:talentos_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query = "UPDATE terminal.empleado SET 
      tipoContrato=:tipoContrato, documento=:documento, numeroContrato=:numeroContrato, inicioContrato=:inicioContrato, finContrato=:finContrato,
        cargo=:cargo, prorroga1=:prorroga1, prorroga2=:prorroga2, prorroga3=:prorroga3, prorroga4=:prorroga4, estado=:estado,talentos_id=:talentos_id
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
     * @return Empleados|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrEmpleados = array();
            $tmp = new Empleados();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Empleado = new Empleados($valor);
                array_push($arrEmpleados, $Empleado);
                unset($Emplaedos);
            }
            return $arrEmpleados;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    /**
     * @param int $id
     * @return Empleados
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Empleados
    {
        try {
            if ($id > 0) {
                $tmpEmpleado = new Empleados();
                $tmpEmpleado->Connect();
                $getrow = $tmpEmpleado->getRow("SELECT * FROM terminal.empleado WHERE id =?", array($id));
                $tmpEmpleado->Disconnect();
                return ($getrow) ? new Empleados($getrow) : null;
            } else {
                throw new Exception('Id de Empleado Invalido');
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
        return Empleados::search("SELECT * FROM terminal.empleado");
    }


    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */

    public static function empleadoRegistrado($documento): bool
    {
        $result = Empleados::search("SELECT * FROM terminal.empleado where documento = '" . $documento . "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString(): string
    {
        return "tipoContrato: $this->tipoContrato,
              documento: $this->documento,
              numeroContrato: $this->numeroContrato,
              inicioContrato: $this->inicioContrato,
              finContrato: $this->finContrato,
              cargo: $this->cargo,
              prorroga1: $this->prorroga1,
              prorroga2: $this->prorroga2,
              prorroga3: $this->prorroga3,
              prorroga4: $this->prorroga4,
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
            'tipoContrato' => $this->getTipoContrato(),
            'documento' => $this->getDocumento(),
            'numeroContrato' => $this->getNumeroContrato(),
            'inicioContrato' => $this->getInicioContrato(),
            'finContrato' => $this->getFinContrato(),
            'cargo'=>$this->getCargo(),
            'prorroga1'=>$this->getProrroga1(),
            'prorroga2'=>$this->getProrroga2(),
            'prorroga3'=>$this->getProrroga3(),
            'prorroga4'=>$this->getProrroga4(),
            'estado' => $this->getEstado(),
            'talentos' => $this->getTalentosId()->jsonSerialize(),
        ];
    }
}