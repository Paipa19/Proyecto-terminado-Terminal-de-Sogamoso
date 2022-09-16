<?php

namespace App\Models;

use App\Enums\Estado;
use App\Interfaces\Model;

class Registros extends AbstractDBConnection implements \App\Interfaces\Model
{

    private ?int $id;
    private string $numeroGaveta;
    private string $numeroCarpetas;
    private string $numeroFolios;
    private string $documento;
    private string $nombre;
    private string $apellido;
    private string $cargo;
    private string $numeroArchivador;
    private string $tipoVinculacion;
    private Estado $estado;
    private int  $usuarios_id;

    /* Relaciones */
    private ?Usuarios $usuario;

    /**
     * @param int|null $id
     * @param string $tipoVinculacion
     * @param string $numeroArchivador
     * @param string $numeroGaveta
     * @param string $numeroCarpetas
     * @param string $numeroFolios
     * @param string $documento
     * @param string $nombre
     * @param string $apellido
     * @param string $cargo
     * @param Estado $estado
     * @param int $usuarios_id
     */
    public function __construct(array $historiasLaborales=[])
    {
        parent::__construct();
        $this->setId($historiasLaborales['id']?? null);
        $this->setNumeroGaveta ($historiasLaborales['numeroGaveta']??'');
        $this->setNumeroCarpetas ($historiasLaborales['numeroCarpetas']??'');
        $this->setNumeroFolios ($historiasLaborales['numeroFolios']??'');
        $this->setNumeroArchivador($historiasLaborales['numeroArchivador']??'');
        $this->setDocumento ($historiasLaborales['documento']??'');
        $this->setNombre ($historiasLaborales['nombre']??'');
        $this->setApellido ($historiasLaborales['apellido']??'');
        $this->setCargo ($historiasLaborales['cargo']??'');
        $this->setTipoVinculacion($historiasLaborales['tipoVinculacion']??'');
        $this->setEstado($historiasLaborales['estado'] ?? Estado::ACTIVO);
        $this->setUsuariosId($historiasLaborales['usuarios_id'] ?? 0);
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
    public function getNumeroGaveta(): string
    {
        return $this->numeroGaveta;
    }

    /**
     * @param string $numeroGaveta
     */
    public function setNumeroGaveta(string $numeroGaveta): void
    {
        $this->numeroGaveta = $numeroGaveta;
    }

    /**
     * @return string
     */
    public function getNumeroCarpetas(): string
    {
        return $this->numeroCarpetas;
    }

    /**
     * @param string $numeroCarpetas
     */
    public function setNumeroCarpetas(string $numeroCarpetas): void
    {
        $this->numeroCarpetas = $numeroCarpetas;
    }

    /**
     * @return string
     */
    public function getNumeroFolios(): string
    {
        return $this->numeroFolios;
    }

    /**
     * @param string $numeroFolios
     */
    public function setNumeroFolios(string $numeroFolios): void
    {
        $this->numeroFolios = $numeroFolios;
    }

    /**
     * @return string
     */
    public function getNumeroArchivador(): string
    {
        return $this->numeroArchivador;
    }

    /**
     * @param string $numeroArchivador
     */
    public function setNumeroArchivador(string $numeroArchivador): void
    {
        $this->numeroArchivador = $numeroArchivador;
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
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }



    /**
     * @return string
     */
    public function getApellido(): string
    {
        return $this->apellido;
    }

    /**
     * @param string $apellido
     */
    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
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
    public function getTipoVinculacion(): string
    {
        return $this->tipoVinculacion;
    }

    /**
     * @param string $tipoVinculacion
     */
    public function setTipoVinculacion(string $tipoVinculacion): void
    {
        $this->tipoVinculacion = $tipoVinculacion;
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
     * Retorna el objeto usuario del cliente correspondiente al historial laboral
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
                ':numeroGaveta' => $this->getNumeroGaveta(),
                ':numeroCarpetas' => $this->getNumeroCarpetas(),
                ':numeroFolios' => $this->getNumeroFolios(),
                ':numeroArchivador' => $this->getNumeroArchivador(),
                ':documento' => $this->getDocumento(),
                ':nombre' => $this->getNombre(),
                ':apellido' => $this->getApellido(),
                ':cargo' => $this->getCargo(),
                ':tipoVinculacion' =>$this->getTipoVinculacion(),
                ':estado' => $this->getEstado(),
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
        $query ="INSERT INTO terminal.registros VALUES (
           :id, :numeroGaveta,:numeroCarpetas,:numeroFolios,:numeroArchivador, :documento, :nombre, :apellido, :cargo,:tipoVinculacion,:estado,:usuarios_id)";
        return $this->save($query);
    }

    function update(): ?bool
    {
        $query = "UPDATE terminal.registros SET 
              numeroGaveta =:numeroGaveta, numeroCarpetas=:numeroCarpetas, numeroFolios=:numeroFolios,numeroArchivador = :numeroArchivador,
               documento=:documento, nombre=:nombre, apellido=:apellido, cargo=:cargo, tipoVinculacion=:tipoVinculacion,                    
               estado=:estado, usuarios_id =:usuarios_id 
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
     * @return Registros|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrHistoriasLaborales = array();
            $tmp = new Registros();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $HistoriasLaborales = new Registros($valor);
                array_push($arrHistoriasLaborales, $HistoriasLaborales);
                unset($HistoriasLaborales);
            }
            return $arrHistoriasLaborales;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    /**
     * @param int $id
     * @return Registros
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Registros
    {

        try {
            if ($id > 0) {
                $tmpHistoriasLaborales = new Registros();
                $tmpHistoriasLaborales->Connect();
                $getrow = $tmpHistoriasLaborales->getRow("SELECT * FROM terminal.registros WHERE id =?", array($id));
                $tmpHistoriasLaborales->Disconnect();
                return ($getrow) ? new Registros($getrow) : null;
            } else {
                throw new Exception('Id de Historia laboral Invalido');
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
    public static function getAll(String $string = ''): ?array
    {
        return Registros::search("SELECT * FROM terminal.registros".$string);
    }

    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */

    public static function historiaLaboralRegistrado($documento): bool
    {
        $result = Registros::search("SELECT * FROM terminal.registros where documento= '" . $documento . "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function __toString(): string
    {
        return "
                numeroGaveta: $this->numeroGaveta,
                numeroCarpetas: $this->numeroCarpetas,
                numeroFolios: $this->numeroFolios,
                numeroArchivador: $this->numeroArchivador,
                documento: $this->documento,
                nombre: $this->nombre,
                apellido: $this->apellido,
                cargo: $this->cargo,   
                tipoVinculacion: $this->tipoVinculacion,       
                usuarios: ".$this->getUsuario()->nombresCompletos().",
                estado: ".$this->getEstado();

    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'numeroGaveta'=>$this->getNumeroGaveta(),
            'numeroCarpetas'=> $this->getNumeroCarpetas(),
            'numeroFolios'=>$this->getNumeroFolios(),
            'numeroArchivador' => $this->getNumeroArchivador(),
            'documento'=> $this->getDocumento(),
            'nombre'=> $this->getNombre(),
            'apellido'=> $this->getApellido(),
            'cargo'=> $this->getCargo(),
            'tipoVinculacion'=> $this->getTipoVinculacion(),
            'estado'=>$this->getEstado(),
            'usuarios'=> $this->getUsuariosId()->jsonSerialize(),

        ];
    }
}