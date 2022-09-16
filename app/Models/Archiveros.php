<?php

namespace App\Models;


use App\Interfaces\Model;

class Archiveros extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $numBoletin;
    private string $numRecibo;
    private string $numEstante;
    private string $numFolios;
    private string $numCaja;
    private string $nivelEstante;
    private string $numCarpeta;
    private int $ingresos_id;

    //Relaciones
    private ?Ingresos $ingresos;

    /**
     * @param int|null $id
     * @param string $numBoletin
     * @param string $numRecibo
     * @param string $numEstante
     * @param string $numFolios
     * @param string $numCaja
     * @param string $nivelEestante
     * @param string $numCarpeta
     * @param int $ingresos_id
     */
    public function __construct( array $archiveros=[])
    {
        parent::__construct();
        $this->setId($archiveros['id'] ?? null);
        $this->setNumBoletin($archiveros['numBoletin']?? '');
        $this->setNumRecibo($archiveros ['numRecibo']?? '');
        $this->setNumEstante($archiveros ['numEstante']?? '');
        $this->setNumFolios ($archiveros ['numFolios'] ?? '');
        $this->setNumCaja ($archiveros ['numCaja'] ?? '');
        $this->setNivelEstante ($archiveros ['nivelEstante']?? '');
        $this->setNumCarpeta ($archiveros ['numCarpeta'] ?? '');
        $this->setIngresosId($archiveros['ingresos_id'] ?? 0);
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
    public function getNumBoletin(): string
    {
        return $this->numBoletin;
    }

    /**
     * @param string $numBoletin
     */
    public function setNumBoletin(string $numBoletin): void
    {
        $this->numBoletin = $numBoletin;
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
    public function getNumRecibo(): string
    {
        return $this->numRecibo;
    }

    /**
     * @param string $numRecibo
     */
    public function setNumRecibo(string $numRecibo): void
    {
        $this->numRecibo = $numRecibo;
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
     * @return int
     */
    public function getIngresosId(): int
    {
        return $this->ingresos_id;
    }

    /**
     * @param int $ingresos_id
     */
    public function setIngresosId(int $ingresos_id): void
    {
        $this->ingresos_id = $ingresos_id;
    }

    /**
     * Retorna el objeto del Ingreso  correspondiente al archivador
     * @return Ingresos|null
     */
    public function getIngresos(): ?Ingresos
    {
        if(!empty($this->ingresos_id)){
            $this->ingreso= Ingresos::searchForId($this->ingresos_id) ?? new Ingresos();
            return $this->ingreso;
        }
        return NULL;
    }

    /**
     * @param Ingresos|null $ingresos
     */
    public function setIngresos(?Ingresos $ingresos): void
    {
        $this->ingresos = $ingresos;
    }



    protected function save(string $query): ?bool
    {
        {
            $arrData = [
                ':id' => $this->getId(),
                ':numBoletin'=>$this->getNumBoletin(),
                ':numRecibo' => $this->getNumRecibo(),
                ':numEstante' => $this->getNumEstante(),
                ':numFolios' => $this->getNumFolios(),
                ':numCaja' => $this->getNumCaja(),
                ':nivelEstante' => $this->getNivelEstante(),
                ':numCarpeta' => $this->getNumCarpeta(),
                ':ingresos_id'=>$this->getIngresosId(),
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
        $query ="INSERT INTO terminal.archiveros VALUES (
       :id, :numBoletin,:numRecibo, :numEstante ,:numFolios, :numCaja, :nivelEstante,:numCarpeta, :ingresos_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query ="UPDATE terminal.archiveros SET 
        numBoletin=:numBoletin,numRecibo=:numRecibo, numEstante=:numEstante, numFolios=:numFolios, numCaja=:numCaja, nivelEstante=:nivelEstante,
          numCarpeta=:numCarpeta, ingresos_id=:ingresos_id
             WHERE id = :id";
        return $this->save($query);

    }
    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setNumEstante("");
        return $this->update();
    }

    /**
     * @param $query
     * @return Archiveros|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrArchiveros = array();
            $tmp = new Archiveros();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Archivero = new Archiveros($valor);
                array_push($arrArchiveros, $Archivero);
                unset($Archiveros);
            }
            return $arrArchiveros;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    /**
     * @param int $id
     * @return Archiveros
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Archiveros
    {
        try {
            if ($id > 0) {
                $tmpArchivero = new Archiveros();
                $tmpArchivero->Connect();
                $getrow = $tmpArchivero->getRow("SELECT * FROM terminal.archiveros WHERE id =?", array($id));
                $tmpArchivero->Disconnect();
                return ($getrow) ? new Archiveros($getrow) : null;
            } else {
                throw new Exception('Id de Archivero Invalido');
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
        return Archiveros::search("SELECT * FROM terminal.archiveros");
    }


    /**
     * @param $numRecibo
     * @return bool
     * @throws Exception
     */

    public static function archiveroRegistrado($numRecibo): bool
    {
        $result = Archiveros::search("SELECT * FROM terminal.archiveros where numRecibo = '" . $numRecibo . "'");
        if (!empty($result) && count($result)>0) {
            return true;
        } else {
            return false;
        }
    }


    public function __toString(): string
    {
        return "
          numBoletin: $this->numBoletin,
          numRecibo: $this->numRecibo,
          numEstante: $this->numEstante,
          numFolios: $this->numFolios,
          numCaja:$this->numCaja,
          nivelEstante: $this->nivelEstante,
          numCarpeta :$this->numCarpeta,
          ingresos: ".$this->ingresos_id;



    }
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'numBoletin'=>$this->getNumBoletin(),
            'numRecibo' => $this->getNumRecibo(),
            'numEstante' => $this->getNumEstante(),
            'numFolios' => $this->getNumFolios(),
            'numCaja' => $this->getNumCaja(),
            'nivelEstante' => $this->getNivelEstante(),
            'numCarpeta' => $this->getNumCarpeta(),
            'ingresos'=>$this->getIngresosId()->jsonSerialize(),
        ];
    }
}