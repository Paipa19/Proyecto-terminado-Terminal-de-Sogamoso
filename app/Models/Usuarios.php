<?php

namespace App\Models;

require_once ("AbstractDBConnection.php");
require_once (__DIR__."\..\Interfaces\Model.php");
require_once (__DIR__.'/../../vendor/autoload.php');

use App\Enums\Estado;
use App\Interfaces\Model;
use App\Enums\Rol;
use Exception;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;


class Usuarios extends AbstractDBConnection implements \App\Interfaces\Model
{
    private ?int $id;
    private string $documento;
    private string $nombre;
    private string $apellido;
    private string $telefono;
    private string $correo;
    private Rol $rol;
    private ?string $usuario;
    private ?string $contrasena;
    private Estado $estado;


    /* Seguridad de Contraseña */
    const HASH = PASSWORD_DEFAULT;
    const COST = 10;

    /**
     * @param int|null $id
     * @param string $documento
     * @param string $nombre
     * @param string $apellido
     * @param string $telefono
     * @param string $correo
     * @param string $rol
     * @param string $usuario
     * @param string|null $contrasena
     * @param string $estado
     */
    public function __construct(array $usuario = [])
    {
        parent::__construct();
        $this->setId($usuario['id'] ?? null);
        $this->setNombre($usuario['nombre'] ?? '');
        $this->setApellido($usuario['apellido'] ?? '');
        $this->setDocumento($usuario['documento'] ??'');
        $this->setTelefono($usuario['telefono'] ?? '');
        $this->setCorreo($usuario['correo'] ?? '');
        $this->setRol($usuario['rol'] ?? Rol::ADMINISTRADOR);
        $this->setUsuario($usuario['usuario'] ?? null);
        $this->setContrasena($usuario['contrasena'] ?? null);
        $this->setEstado($usuario['estado'] ?? Estado::ACTIVO);

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
    public function getRol(): string
    {
        return $this->rol->toString();
    }


    /**
     * @param string $rol
     */
    public function setRol(null|string|Rol $rol): void
    {
        if(is_string($rol)){
            $this->rol = Rol::from($rol);
        }else{
            $this->rol = $rol;
        }
    }

    /**
     * @return string|null
     */
    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    /**
     * @param string|null $usuario
     */
    public function setUsuario(?string $usuario): void
    {
        $this->usuario = $usuario;
    }


    /**
     * @return mixed|string
     */
    public function getContrasena(): ?string
    {
        return $this->contrasena;
    }

    /**
     * @param mixed|string $contrasena
     */
    public function setContrasena(?string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    /**
     * @return Estado
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


    protected function save(string $query): ?bool
    {
        if($this->contrasena != null){
            $pos = strpos($this->contrasena, '$2y$10$');
            if($pos === false){
                $hashcontrasena = password_hash($this->contrasena, self::HASH, ['cost' => self::COST]);
            }else{
                $hashcontrasena = $this->contrasena;
            }
        }
        $arrData = [

            ':id' => $this->getId(),
            ':documento' => $this->getDocumento(),
            ':nombre' => $this->getNombre(),
            ':apellido' => $this->getApellido(),
            ':telefono' => $this->getTelefono(),
            ':correo' => $this->getCorreo(),
            ':rol' => $this->getRol(),
            ':usuario' =>  $this->getUsuario(),
            ':contrasena' => $hashcontrasena,
            ':estado' => $this->getEstado()

        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return bool|null
     */

    function insert(): ?bool
    {
        $query = "INSERT INTO terminal.usuarios Values (
           :id,:documento,:nombre,:apellido,:telefono,
           :correo,:rol,:usuario, :contrasena,:estado)";

        return $this->save($query);
    }

    function update(): ?bool
    {
        $query = "UPDATE terminal.usuarios SET
       documento = :documento, nombre = :nombre, apellido = :apellido,
        telefono = :telefono, correo = :correo, rol = :rol, usuario = :usuario, contrasena = :contrasena, estado= :estado
        WHERE id = :id";

        return $this->save($query);
    }

    /**
     * @return bool
     * @throws Exception
     */
    function deleted(): ?bool
    {
        $this->setEstado( "Inactvo");
        return $this->update();
    }

    /**
     * @param $query
     * @return Usuario|array
     * @throws Exception
     */

    static function search($query): ?array
    {
        try {
            $arrUsuarios = array();
            $tmp = new Usuarios();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Usuario = new Usuarios($valor);
                    array_push($arrUsuarios, $Usuario);
                    unset($Usuario);
                }
                return $arrUsuarios;
            }
            return null;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }
    /**
     * @param int $id
     * @return Usuarios|null
     */
    public static function searchForId(int $id): ?Usuarios
    {
        try {
            if ($id > 0) {
                $tmpUsuario = new Usuarios();
                $tmpUsuario->Connect();
                $getrow = $tmpUsuario->getRow("SELECT * FROM terminal.usuarios WHERE id =?", array($id));
                $tmpUsuario->Disconnect();
                return ($getrow) ? new Usuarios($getrow) : null;
            } else {
                throw new Exception('Id de usuario Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    static function getAll(): ?array
    {
        return Usuarios::search("SELECT * FROM terminal.usuarios");
    }

    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */

    public static function usuarioRegistrado($documento): bool
    {
        $result = Usuarios::search("SELECT * FROM terminal.usuarios where documento = " . $documento);
        if (!empty($result) && count($result)>0) {
            return true;
        } else {
            return false;
        }
    }

    public function nombresCompletos(): string
    {
        return $this->nombre . " " . $this->apellido;
    }

    public function __toString(): string
    {
        return "documento: $this->documento, 
                nombre: $this->nombre, 
                apellido: $this->apellido, 
                Telefono: $this->telefono, 
                correo: $this->correo, 
                rol: ".$this->getRol().", 
                usuario: $this->usuario, 
                contrasena: $this->contrasena,
                estado: ".$this->getEstado();
    }
    public function login($usuario, $contrasena): Usuarios|String|null
    {

        try {
            $resultUsuarios = Usuarios::search("SELECT * FROM usuarios WHERE usuario = '$usuario'");
            /* @var $resultUsuarios Usuarios[] */
            if (!empty($resultUsuarios) && count($resultUsuarios) >= 1) {
                if (password_verify($contrasena, $resultUsuarios[0]->getContrasena())) {
                    if ($resultUsuarios[0]->getEstado() == 'Activo') {
                        return $resultUsuarios[0];
                    } else {
                        return "Usuario Inactiva";
                    }
                } else {
                    return "Contraseña Incorrecta";
                }
            } else {
                return "Usuario Incorrecto";
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
            return "Error en Servidor";
        }
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'documento' => $this->getDocumento(),
            'nombre' => $this->getNombre(),
            'apellido' => $this->getApellido(),
            'correo' => $this->getCorreo(),
            'telefono' => $this->getTelefono(),
            'rol' => $this->getRol(),
            'usuario' => $this->getUsuario(),
            'contrasena'=> $this->getContrasena(),
            'estado' => $this->getEstado(),

        ];
    }

}