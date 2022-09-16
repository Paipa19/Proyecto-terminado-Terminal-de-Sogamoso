<?php

namespace App\Models;



use App\Interfaces\Model;


class Egresos extends AbstractDBConnection implements \App\Interfaces\Model
{
    private ?int $id;
    private string $numeroComprobante;
    private string $fechaComprobante;
    private string $nombreBeneficiario;
    private string $numeroIdentificacion;
    private string $concepto;
    private string $numContrato;
    private string $fechaContrato;
    private int  $usuarios_id;



    /* Relaciones */
    private ?Usuarios $usuario;



    /**
     * @param int|null $id
     * @param string $numeroComprobante
     * @param string $fechaComprobante
     * @param string $nombreBeneficiario
     * @param string $numeroIdentificacion
     * @param string $concepto
     * @param int $usuarios_id
     */
    public function __construct(array $egresos=[])

    {
        parent::__construct();
        $this->setId($egresos['id']?? null);
        $this->setNumeroComprobante($egresos['numeroComprobante']??'');
        $this->setFechaComprobante($egresos['fechaComprobante'] ??'');
        $this->setNombreBeneficiario($egresos['nombreBeneficiario'] ??'');
        $this->setNumeroIdentificacion($egresos['numeroIdentificacion'] ??'');
        $this->setConcepto($egresos['concepto'] ??'');
        $this->setNumContrato($egresos['numContrato'] ??'');
        $this->setFechaContrato($egresos['fechaContrato'] ??'');
        $this->setUsuariosId($egresos['usuarios_id'] ?? 0);
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
    public function getNumeroComprobante(): string
    {
        return $this->numeroComprobante;
    }

    /**
     * @param string $numeroComprobante
     */
    public function setNumeroComprobante(string $numeroComprobante): void
    {
        $this->numeroComprobante = $numeroComprobante;
    }

    /**
     * @return string
     */
    public function getFechaComprobante(): string
    {
        return $this->fechaComprobante;
    }

    /**
     * @param string $fechaComprobante
     */
    public function setFechaComprobante(string $fechaComprobante): void
    {
        $this->fechaComprobante = $fechaComprobante;
    }


    /**
     * @return string
     */
    public function getNombreBeneficiario(): string
    {
        return $this->nombreBeneficiario;
    }

    /**
     * @param string $nombreBeneficiario
     */
    public function setNombreBeneficiario(string $nombreBeneficiario): void
    {
        $this->nombreBeneficiario = $nombreBeneficiario;
    }



    /**
     * @return string
     */
    public function getNumeroIdentificacion(): string
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param string $numeroIdentificacion
     */
    public function setNumeroIdentificacion(string $numeroIdentificacion): void
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
    }

    /**
     * @return string
     */
    public function getConcepto(): string
    {
        return $this->concepto;
    }

    /**
     * @param string $concepto
     */
    public function setConcepto(string $concepto): void
    {
        $this->concepto = $concepto;
    }

    /**
     * @return string
     */
    public function getNumContrato(): string
    {
        return $this->numContrato;
    }

    /**
     * @param string $numContrato
     */
    public function setNumContrato(string $numContrato): void
    {
        $this->numContrato = $numContrato;
    }

    /**
     * @return string
     */
    public function getFechaContrato(): string
    {
        return $this->fechaContrato;
    }

    /**
     * @param string $fechaContrato
     */
    public function setFechaContrato(string $fechaContrato): void
    {
        $this->fechaContrato = $fechaContrato;
    }



    /**
     * @return int
     */
    public function getUsuariosId(): int
    {
        return $this->usuarios_id;
    }

    /**
     * @param int $usuarios_id
     */
    public function setUsuariosId(int $usuarios_id): void
    {
        $this->usuarios_id = $usuarios_id;
    }



    /**
     * Retorna el objeto usuario del cliente correspondiente al comprobante
     * @return Usuarios|null
     */
    public function getUsuario(): ?Usuarios
    {
        if(!empty($this->usuarios_id)){
            $this->usuario = Usuarios::searchForId($this->usuarios_id) ?? new Usuarios();
            return $this->usuario;
        }
        return NULL;
    }

    /**
     * @param Usuarios|null $usuario
     */
    public function setUsuario(?Usuarios $usuario): void
    {
        $this->usuario = $usuario;
    }



    protected function save(string $query): ?bool
    {
        {
            $arrData = [
                ':id' => $this->getId(),
                ':numeroComprobante' => $this->getNumeroComprobante(),
                ':fechaComprobante' => $this->getFechaComprobante(),
                ':nombreBeneficiario' => $this->getNombreBeneficiario(),
                ':numeroIdentificacion' => $this->getNumeroIdentificacion(),
                ':concepto' => $this->getConcepto(),
                ':numContrato' => $this->getNumContrato(),
                ':fechaContrato' => $this->getFechaContrato(),
                ':usuarios_id' => $this->getUsuariosId(),


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
        $query ="INSERT INTO terminal.egresos VALUES (
           :id,:numeroComprobante,:fechaComprobante,:nombreBeneficiario, :numeroIdentificacion,:concepto, :numContrato, :fechaContrato,:usuarios_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query = "UPDATE terminal.egresos SET 
               numeroComprobante = :numeroComprobante,fechaComprobante =:fechaComprobante, nombreBeneficiario=:nombreBeneficiario, 
                numeroIdentificacion=:numeroIdentificacion, concepto=:concepto, numContrato=:numContrato, fechaContrato=:fechaContrato,
                usuarios_id =:usuarios_id
                 WHERE id = :id";
        return $this->save($query);

    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setNumeroComprobante("");
        return $this->update();
    }


    /**
     * @param $query
     * @return Egresos|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrEgresos = array();
            $tmp = new Egresos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Egreso = new Egresos($valor);
                array_push($arrEgresos, $Egreso);
                unset($Egreso);
            }
            return $arrEgresos;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }


    /**
     * @param int $id
     * @return Egresos
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Egresos
    {

        try {
            if ($id > 0) {
                $tmpEgreso = new Egresos();
                $tmpEgreso->Connect();
                $getrow = $tmpEgreso->getRow("SELECT * FROM terminal.egresos WHERE id =?", array($id));
                $tmpEgreso->Disconnect();
                return ($getrow) ? new Egresos($getrow) : null;
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
        return Egresos::search("SELECT * FROM terminal.egresos");
    }

    /**
     * @param $numeroComprobante
     * @return bool
     * @throws Exception
     */

    public static function egresoRegistrado($numeroComprobante): bool
    {
        $result = Egresos::search("SELECT * FROM terminal.egresos where numeroComprobante = '" . $numeroComprobante. "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString(): string
    {
        return "numeroComprobante: $this->numeroComprobante,
                fechaComprobante: $this->fechaComprobante$,
                nombreBeneficiario: $this->nombreBeneficiario,
                numeroIdentificacion: $this->numeroIdentificacion,
                concepto: $this->concepto,
                numContrato: $this->numContrato,
                usuarios: ".$this->getUsuario()->nombresCompletos().",
                fechaContrato ".$this->fechaContrato;

    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'numeroComprobante' => $this->getNumeroComprobante(),
            'fechaComprobante' => $this->getFechaComprobante(),
            'nombreBeneficiario'=> $this->getNombreBeneficiario(),
            'numeroIdentificacion'=> $this->getNumeroIdentificacion(),
            'concepto' => $this->getConcepto(),
            'numContrato' => $this->getNumContrato(),
            'fechaContrato' => $this->getFechaContrato(),
            'usuarios'=> $this->getUsuariosId()->jsonSerialize(),


        ];
    }

}