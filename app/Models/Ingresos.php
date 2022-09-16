<?php

namespace App\Models;

use App\Interfaces\Model;


class Ingresos extends AbstractDBConnection implements \App\Interfaces\Model
{

   private ?int $id;
   private string $numeroCaja;
   private string $numeroBoletin;
   private string $fecha;
   private string $nombreBeneficiario;
   private string $numeroRecibo;
   private string $concepto;
   private int $usuarios_id;



    /* Relaciones */
    private ?Usuarios $usuario;


    /**
     * @param int|null $id
     * @param string $numeroCaja
     * @param string $numeroBoletin
     * @param string $fecha
     * @param string $nombreBeneficiario
     * @param string $numeroRecibo
     * @param string $concepto
     * @param int $usuarios_id
     */
    public function __construct(array $ingresos=[])
    {
        parent::__construct();
        $this->setId($ingresos['id']?? null);
        $this->setNumeroCaja($ingresos['numeroCaja']??'');
        $this->setNumeroBoletin($ingresos ['numeroBoletin']??'');
        $this->setFecha($ingresos ['fecha']??'');
        $this->setNombreBeneficiario ($ingresos['nombreBeneficiario']??'');
        $this->setNumeroRecibo($ingresos['numeroRecibo']??'');
        $this->setConcepto($ingresos['concepto'] ??'');
        $this->setusuariosId($ingresos ['usuarios_id']??0);

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
    public function getNumeroCaja(): string
    {
        return $this->numeroCaja;
    }

    /**
     * @param string $numeroCaja
     */
    public function setNumeroCaja(string $numeroCaja): void
    {
        $this->numeroCaja = $numeroCaja;
    }

    /**
     * @return string
     */
    public function getNumeroBoletin(): string
    {
        return $this->numeroBoletin;
    }

    /**
     * @param string $numeroBoletin
     */
    public function setNumeroBoletin(string $numeroBoletin): void
    {
        $this->numeroBoletin = $numeroBoletin;
    }


    /**
     * @return string
     */
    public function getFecha(): string
    {
        return $this->fecha;
    }

    /**
     * @param string $fecha
     */
    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
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
    public function getNumeroRecibo(): string
    {
        return $this->numeroRecibo;
    }

    /**
     * @param string $numeroRecibo
     */
    public function setNumeroRecibo(string $numeroRecibo): void
    {
        $this->numeroRecibo = $numeroRecibo;
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
     * Retorna el objeto usuario del cliente correspondiente al boletin
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
                ':numeroCaja' => $this->getNumeroCaja(),
                ':numeroBoletin'=>$this->getNumeroBoletin(),
                ':fecha' => $this->getFecha(),
                ':nombreBeneficiario'=> $this->getNombreBeneficiario(),
                ':numeroRecibo' => $this->getNumeroRecibo(),
                ':concepto' => $this->getConcepto(),
                ':usuarios_id' => $this->getUsuariosId(),

            ];

            $this->Connect();
            $result = $this->insertRow($query, $arrData);
            $this->Disconnect();
            return $result;
        }
    }

    function insert(): ?bool
    {
        $query ="INSERT INTO terminal.ingresos VALUES (
       :id,:numeroCaja,:numeroBoletin,:fecha,:nombreBeneficiario,
       :numeroRecibo,:concepto,:usuarios_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query ="UPDATE terminal.ingresos SET 
        numeroCaja = :numeroCaja, numeroBoletin =:numeroBoletin,fecha=:fecha, nombreBeneficiario=:nombreBeneficiario,
        numeroRecibo=:numeroRecibo, concepto=:concepto, 
        usuarios_id=:usuarios_id               
        WHERE id = :id";
        return $this->save($query);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setNumeroBoletin("");
        return $this->update();
    }


    public static function search($query): ?array
    {
        try {
            $arrIngresos = array();
            $tmp = new Ingresos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Ingresos = new Ingresos($valor);
                array_push($arrIngresos, $Ingresos);
                unset($Ingresos);
            }
            return $arrIngresos;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }


    /**
     * @param int $id
     * @return Ingresos
     * @throws Exception
     * @throws e
     */

    public static function searchForID(int $id): ?Ingresos
    {
        try {
            if ($id > 0) {
                $tmpIngreso = new Ingresos();
                $tmpIngreso->Connect();
                $getrow = $tmpIngreso->getRow("SELECT * FROM terminal.ingresos WHERE id =?", array($id));
                $tmpIngreso->Disconnect();
                return ($getrow) ? new Ingresos($getrow) : null;
            } else {
                throw new Exception('Id de ingreso Invalido');
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
        return Ingresos::search("SELECT * FROM terminal.ingresos");
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */

    public static function ingresoRegistrado($id): bool
    {
        $result =Ingresos::search("SELECT * FROM terminal.ingresos where id = '" . $id. "'");
        if (!empty($result) && count($result)>0) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString(): string
    {
        return
            "numeroCaja: $this->numeroCaja,
             numeroBoletin: $this->numeroBoletin,
             fecha: $this->fecha,
             nombreBeneficiario: $this->nombreBeneficiario,
             numeroRecibo: $this->numeroRecibo,
             usuarios: ".$this->getUsuario()->nombresCompletos().",
             concepto: ".$this->concepto;

    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
             'id' => $this->getId(),
             'numeroCaja' => $this->getNumeroCaja(),
             'numeroBoletin' => $this->getNumeroBoletin(),
             'fecha' => $this->getFecha(), //Y-M-D
             'nombreBeneficiario' => $this->getNombreBeneficiario(),
             'numeroRecibo'=>$this->getNumeroRecibo(),
             'concepto'=>$this->getConcepto(),
             'usuarios'=> $this->getUsuariosId()->jsonSerialize(),

        ];
    }
}