<?php

namespace App\Models;



use App\Interfaces\Model;


class Libros extends AbstractDBConnection implements \App\Interfaces\Model
{

    private ?int $id;
    private string $disposicionFinal;
    private string $retencion;
    private string $estanteLibro;
    private string $nivelLibro;
    private string $cantidad;
    private string $numBoletin;
    private string $numComprobante;
    private string $mes;
    private string $agenda;
    private int $usuarios_id;

    /*Relaciones*/
    private ?Usuarios $usuario;

    /**
     * @param int|null $id
     * @param string $disposicionFinal
     * @param string $retencion
     * @param string $estanteLibro
     * @param string $nivelLibro
     * @param string $numBoletin
     * @param string $numComprobante
     * @param string $mes
     * @param string $agenda
     * @param int $usuarios_id
     */
    public function __construct(array $libros=[])
    {
        parent::__construct();

        $this->setId($libros['id']?? null);
        $this->setDisposicionFinal($libros['disposicionFinal']??'');
        $this->setRetencion($libros['retencion']??'');
        $this->setEstanteLibro($libros['estanteLibro']??'');
        $this->setNivelLibro ($libros['nivelLibro']??'');
        $this->setCantidad($libros['cantidad']??'');
        $this->setNumBoletin($libros['numBoletin']??'');
        $this->setNumComprobante($libros['numComprobante']??'');
        $this->setMes($libros['mes']??'');
        $this->setAgenda($libros['agenda']??'');
        $this->setUsuariosId($libros['usuarios_id'] ?? 0);
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
    public function getDisposicionFinal(): string
    {
        return $this->disposicionFinal;
    }

    /**
     * @param string $disposicionFinal
     */
    public function setDisposicionFinal(string $disposicionFinal): void
    {
        $this->disposicionFinal = $disposicionFinal;
    }

    /**
     * @return string
     */
    public function getRetencion(): string
    {
        return $this->retencion;
    }

    /**
     * @param string $retencion
     */
    public function setRetencion(string $retencion): void
    {
        $this->retencion = $retencion;
    }

    /**
     * @return string
     */
    public function getEstanteLibro(): string
    {
        return $this->estanteLibro;
    }

    /**
     * @param string $estanteLibro
     */
    public function setEstanteLibro(string $estanteLibro): void
    {
        $this->estanteLibro = $estanteLibro;
    }

    /**
     * @return string
     */
    public function getNivelLibro(): string
    {
        return $this->nivelLibro;
    }

    /**
     * @param string $nivelLibro
     */
    public function setNivelLibro(string $nivelLibro): void
    {
        $this->nivelLibro = $nivelLibro;
    }

    /**
     * @return string
     */
    public function getCantidad(): string
    {
        return $this->cantidad;
    }

    /**
     * @param string $cantidad
     */
    public function setCantidad(string $cantidad): void
    {
        $this->cantidad = $cantidad;
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
    public function getMes(): string
    {
        return $this->mes;
    }

    /**
     * @param string $mes
     */
    public function setMes(string $mes): void
    {
        $this->mes = $mes;
    }

    /**
     * @return string
     */
    public function getAgenda(): string
    {
        return $this->agenda;
    }

    /**
     * @param string $agenda
     */
    public function setAgenda(string $agenda): void
    {
        $this->agenda = $agenda;
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
     * Retorna el objeto usuario del cliente correspondiente al libro
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
                ':disposicionFinal'=> $this->getDisposicionFinal(),
                ':retencion' => $this->getRetencion(),
                ':estanteLibro' => $this->getEstanteLibro(),
                ':nivelLibro' => $this->getNivelLibro(),
                ':cantidad'=>$this->getCantidad(),
                ':numBoletin' => $this->getNumBoletin(),
                ':numComprobante'=>$this->getNumComprobante(),
                ':mes'=>$this->getMes(),
                 'agenda'=>$this->getAgenda(),
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
        $query ="INSERT INTO terminal.libros VALUES (
           :id,:disposicionFinal, :retencion, :nivelLibro, :estanteLibro,:cantidad,:numBoletin,:numComprobante,:mes, :agenda,:usuarios_id)";
        return $this->save($query);
    }


    function update(): ?bool
    {
        $query = "UPDATE terminal.libros SET 
               estanteLibro =:estanteLibro, nivelLibro =:nivelLibro, cantidad=:cantidad,
                numBoletin=:numBoletin, numComprobante =:numComprobante, mes =:mes,
                agenda=:agenda, disposicionFinal=:disposicionFinal, retencion=:retencion, usuarios_id =:usuarios_id
               WHERE id = :id";
        return $this->save($query);

    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setAgenda("");
        return $this->update();
    }

    /**
     * @param $query
     * @return Libros|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrLibros = array();
            $tmp = new Libros();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Libro = new Libros($valor);
                array_push($arrLibros, $Libro);
                unset($Libro);
            }
            return $arrLibros;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }



    /**
     * @param int $id
     * @return Libros
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Libros
    {
        try {
            if ($id > 0) {
                $tmpLibro = new Libros();
                $tmpLibro->Connect();
                $getrow = $tmpLibro->getRow("SELECT * FROM terminal.libros WHERE id =?", array($id));
                $tmpLibro->Disconnect();
                return ($getrow) ? new Libros($getrow) : null;
            } else {
                throw new Exception('Id del libro Invalido');
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
        return Libros::search("SELECT * FROM terminal.libros");
    }


    /**
     * @param $id
     * @return bool
     * @throws Exception
     */

    public static function libroRegistrado($id): bool
    {
        $result = Libros::search("SELECT * FROM terminal.libros where id = '" . $id . "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString(): string
    {
        return "disposicionFinal: $this->disposicionFinal,
                retencion: $this->retencion,
                nivelLibro: $this->nivelLibro,
                estanteLibro: $this->estanteLibro,
                cantidad: $this->cantidad,
                numBoletin:$this->numBoletin,
                numComprobante:$this->numComprobante,
                mes:$this->mes,
                usuarios: ".$this->getUsuario()->nombresCompletos().",
                agenda:".$this->agenda;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'disposicionFinal'=> $this->getDisposicionFinal(),
            'retencion'=>$this->getRetencion(),
            'nivelLibro' => $this->getNivelLibro(),
            'estanteLibro' => $this->getEstanteLibro(),
            'cantidad'=> $this->getCantidad(),
             'numBoletin'=>$this->getNumBoletin(),
             'numComprobante'=>$this->getNumComprobante(),
             'mes'=>$this->getMes(),
             'agenda'=>$this->getAgenda(),
            'usuarios'=> $this->getUsuariosId()->jsonSerialize(),


        ];
    }
}