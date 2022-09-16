<?php

namespace App\Models;


use App\Interfaces\Model;


class Archivos extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $numFolios;
    private string $numEstante;
    private string $nivelEstante;
    private string $numCaja;
    private string $numCarpeta;
    private string $numComprobante;
    private string $numeroIdentificacion;
    private int $egresos_id;



    //Relaciones
    private ?Egresos $egresos;



    /**
     * @param int|null $id
     * @param string $numFolios
     * @param string $numEstante
     * @param string $nivelEestante
     * @param string $numCaja
     * @param string $numCarpeta
     * @param string $numComprobante
     * @param string $numeroIdentificacion
     * @param int $egresos_id
     */
    public function __construct( array $archivos=[])
    {
        parent::__construct();
        $this->setId($archivos['id'] ?? null);
        $this->setNumFolios ($archivos ['numFolios'] ?? '');
        $this->setNumEstante($archivos ['numEstante']?? '');
        $this->setNivelEstante ($archivos ['nivelEstante']?? '');
        $this->setNumCaja ($archivos ['numCaja'] ?? '');
        $this->setNumCarpeta ($archivos ['numCarpeta'] ?? '');
        $this->setNumComprobante($archivos['numComprobante'] ??'');
        $this->setNumeroIdentificacion($archivos['numeroIdentificacion'] ??'');
        $this->setEgresosId($archivos['egresos_id'] ?? 0);

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
    public function getNumFolios(): string
    {
        return $this->numFolios;
    }

    /**
     * @param string $numFolios
     */
    public function setNumFolios(string $numFolios): void
    {
        $this->numFolios = $numFolios;
    }

    /**
     * @return string
     */
    public function getNumEstante(): string
    {
        return $this->numEstante;
    }

    /**
     * @param string $numEstante
     */
    public function setNumEstante(string $numEstante): void
    {
        $this->numEstante = $numEstante;
    }

    /**
     * @return string
     */
    public function getNivelEstante(): string
    {
        return $this->nivelEstante;
    }

    /**
     * @param string $nivelEstante
     */
    public function setNivelEstante(string $nivelEstante): void
    {
        $this->nivelEstante = $nivelEstante;
    }

    /**
     * @return string
     */
    public function getNumCaja(): string
    {
        return $this->numCaja;
    }

    /**
     * @param string $numCaja
     */
    public function setNumCaja(string $numCaja): void
    {
        $this->numCaja = $numCaja;
    }

    /**
     * @return string
     */
    public function getNumCarpeta(): string
    {
        return $this->numCarpeta;
    }

    /**
     * @param string $numCarpeta
     */
    public function setNumCarpeta(string $numCarpeta): void
    {
        $this->numCarpeta = $numCarpeta;
    }

    /**
     * @return string
     */
    public function getNumComprobante(): string
    {
        return $this->numComprobante;
    }

    /**
     * @param string $numComprobante
     */
    public function setNumComprobante(string $numComprobante): void
    {
        $this->numComprobante = $numComprobante;
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
     * @return int
     */
    public function getEgresosId(): int
    {
        return $this->egresos_id;
    }

    /**
     * @param int $egresos_id
     */
    public function setEgresosId(int $egresos_id): void
    {
        $this->egresos_id = $egresos_id;
    }

    /**
     * Retorna el objeto del egreso  correspondiente al archivador
     * @return Egresos|null
     */
    public function getEgresos(): ?Egresos
    {
        if(!empty($this->egresos_id)){
            $this->egreso= Egresos::searchForId($this->egresos_id) ?? new Egresos();
            return $this->egreso;
        }
        return NULL;
    }

    /**
     * @param Egresos|null $egresos
     */
    public function setEgresos(?Egresos $egresos): void
    {
        $this->egresos = $egresos;
    }




    protected function save(string $query): ?bool
    {
        {
            $arrData = [
                ':id' => $this->getId(),
                ':numFolios' => $this->getNumFolios(),
                ':numEstante' => $this->getNumEstante(),
                ':nivelEstante' => $this->getNivelEstante(),
                ':numCaja' => $this->getNumCaja(),
                ':numCarpeta' => $this->getNumCarpeta(),
                ':numComprobante' => $this->getNumComprobante(),
                ':numeroIdentificacion'=> $this->getNumeroIdentificacion(),
                ':egresos_id'=>$this->getEgresosId(),

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
       $query ="INSERT INTO terminal.archivos VALUES (
       :id, :numFolios,:numEstante,:nivelEstante,:numCaja,:numCarpeta, :numComprobante, :numeroIdentificacion, :egresos_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query ="UPDATE terminal.archivos SET 
         numFolios =:numFolios, numEstante=:numEstante, nivelEstante=:nivelEstante,
         numCaja=:numCaja,numCarpeta=:numCarpeta, numComprobante=:numComprobante,numeroIdentificacion=:numeroIdentificacion, 
         egresos_id=:egresos_id
             WHERE id = :id";
        return $this->save($query);


    }
    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setNumComprobante("");
        return $this->update();
    }

    /**
     * @param $query
     * @return Archivos|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrArchivos = array();
            $tmp = new Archivos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Archivo = new Archivos($valor);
                array_push($arrArchivos, $Archivo);
                unset($Archivos);
            }
            return $arrArchivos;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    /**
     * @param int $id
     * @return Archivos
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Archivos
    {
        try {
            if ($id > 0) {
                $tmpArchivo = new Archivos();
                $tmpArchivo->Connect();
                $getrow = $tmpArchivo->getRow("SELECT * FROM terminal.archivos WHERE id =?", array($id));
                $tmpArchivo->Disconnect();
                return ($getrow) ? new Archivos($getrow) : null;
            } else {
                throw new Exception('Id de Archivo Invalido');
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
        return Archivos::search("SELECT * FROM terminal.archivos");
    }


    /**
     * @param $numComprobante
     * @return bool
     * @throws Exception
     */

    public static function archivoRegistrado($numComprobante): bool
    {
        $result = Archivos::search("SELECT * FROM terminal.archivos where numComprobante = '" . $numComprobante . "'");
        if (!empty($result) && count($result)>0) {
            return true;
        } else {
            return false;
        }
    }


    public function __toString(): string
    {
        return "
          numFolios: $this->numFolios,
          numEstante: $this->numEstante,
          nivelEstante: $this->nivelEstante,
          numCaja:$this->numCaja,
          numCarpeta :$this->numCarpeta,
          numComprobante: $this->numComprobante,
          numeroIdentificacion: $this->numeroIdentificacion,
          egresos_id: ".$this->egresos_id;


    }
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'numFolios' => $this->getNumFolios(),
            'numEstante' => $this->getNumEstante(),
            'nivelEstante' => $this->getNivelEstante(),
            'numCaja' => $this->getNumCaja(),
            'numCarpeta' => $this->getNumCarpeta(),
            'numComprobante' => $this->getNumComprobante(),
            'numeroIdentificacion'=> $this->getNumeroIdentificacion(),
            'egresos_id'=>$this->getEgresosId()->jsonSerialize(),

        ];
    }
}