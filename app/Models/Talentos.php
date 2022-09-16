<?php

namespace App\Models;

use App\Enums\Estado;
use App\Interfaces\Model;
use Carbon\Carbon;

class Talentos extends AbstractDBConnection implements \App\Interfaces\Model
{
    private ?int $id;
    private string $tipoDocumento;
    private string $documento;
    private string $nombres;
    private string $apellidos;
    private string $estadoCivil;
    private string $telefono;
    private string $direccion;
    private string $correo;
    private Estado $estado;
    private int  $usuarios_id;

    /* Relaciones */
    private ?Usuarios $usuario;

    /**
     * @param int|null $id
     * @param string $tipoDocumento
     * @param string $documento
     * @param string $nombres
     * @param string $apellidos
     * @param string $estadoCivil
     * @param string $telefono
     * @param string $direccion
     * @param string $correo
     * @param Estado $estado
     * @param int $usuarios_id
     */
    public function __construct(array $talentosHumanos=[])
    {
        parent::__construct();
        $this->setId($talentosHumanos['id']?? null);
        $this->setTipoDocumento($talentosHumanos['tipoDocumento'] ?? '');
        $this->setDocumento ($talentosHumanos['documento']??'');
        $this->setNombres ($talentosHumanos['nombres']??'');
        $this->setApellidos ($talentosHumanos['apellidos']??'');
        $this->setEstadoCivil ($talentosHumanos['estadoCivil']??'');
        $this->setTelefono ($talentosHumanos['telefono']??'');
        $this->setDireccion ($talentosHumanos['direccion']??'');
        $this->setCorreo ($talentosHumanos['correo']??'');
        $this->setEstado ($talentosHumanos ['estado']?? Estado::ACTIVO);
        $this->setUsuariosId($talentosHumanos['usuarios_id'] ?? 0);
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
    public function getNombres(): string
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }


    /**
     * @return string
     */
    public function getEstadoCivil(): string
    {
        return $this->estadoCivil;
    }

    /**
     * @param string $estadoCivil
     */
    public function setEstadoCivil(string $estadoCivil): void
    {
        $this->estadoCivil = $estadoCivil;
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
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getCorreo(): string
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
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
     * Retorna el objeto usuario
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
                ':tipoDocumento' => $this->getTipoDocumento(),
                ':documento' => $this->getDocumento(),
                ':nombres' => $this->getNombres(),
                ':apellidos' => $this->getApellidos(),
                ':estadoCivil' => $this->getEstadoCivil(),
                ':telefono' => $this->getTelefono(),
                ':direccion' => $this->getDireccion(),
                ':correo' => $this->getCorreo(),
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
            $query = "INSERT INTO terminal.talentos VALUES (
           :id,:tipoDocumento,:documento, :nombres,:apellidos,
            :estadoCivil, :telefono, :direccion  ,:correo , :estado, :usuarios_id)";
            return $this->save($query);
        }

        function update(): ?bool
        {
            $query = "UPDATE terminal.talentos SET 
               tipoDocumento = :tipoDocumento,documento =:documento,nombres=:nombres,
              apellidos=:apellidos, estadoCivil =:estadoCivil, 
                telefono =:telefono, direccion=:direccion, correo=:correo, estado=:estado,  usuarios_id=:usuarios_id       
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
     * @return Talentos|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrTalentosHumanos = array();
            $tmp = new Talentos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $TalentoHumano = new Talentos($valor);
                array_push($arrTalentosHumanos, $TalentoHumano);
                unset($TalentoHumano);
            }
            return $arrTalentosHumanos;
        } catch (Exception $e) {
            \App\Models\GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }


    /**
     * @param int $id
     * @return Talentos
     * @throws Exception
     * @throws e
     */
    public static function searchForID(int $id): ?Talentos
    {

        try {
            if ($id > 0) {
                $tmpTalentoHumano = new Talentos();
                $tmpTalentoHumano->Connect();
                $getrow = $tmpTalentoHumano->getRow("SELECT * FROM terminal.talentos WHERE id =?", array($id));
                $tmpTalentoHumano->Disconnect();
                return ($getrow) ? new Talentos($getrow) : null;
            } else {
                throw new Exception('Id del Talento Humano Invalido');
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
        return Talentos::search("SELECT * FROM terminal.talentos");
    }


    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */

    public static function talentoHumanoRegistrado($documento): bool
    {
        $result = Talentos::search("SELECT * FROM terminal.talentos where documento = '" . $documento. "'");
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString(): string
    {
        return "tipoDocumento: $this->tipoDocumento,
                documento: $this->documento,
                nombres: $this->nombres,
                apellidos:$this->apellidos,
                estadoCivil: $this->estadoCivil,
                telefono: $this->telefono,
                direccion: $this->direccion,
                correo: $this->correo,
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
            'tipoDocumento' => $this->getTipoDocumento(),
            'documento' => $this->getDocumento(),
            'nombres' => $this->getNombres(),
            'apellidos'=> $this->getApellidos(),
            'estadoCivil'=> $this->getEstadoCivil(),
            'telefono'=>$this->getTelefono(),
            'direccion'=> $this->getDireccion(),
            'correo'=> $this->getCorreo(),
            'usuarios'=> $this->getUsuariosId()->jsonSerialize(),
            'estado'=>$this->getEstado(),

        ];
    }

}