<?php

namespace Tests\Unit\models;

use App\Enums\Estado;
use App\Enums\Rol;
use App\Models\Usuarios;
use PHPUnit\Framework\TestCase;

class UsuariosTest extends TestCase
{


    public function testInsert()
    {
        $Usuario = new Usuarios(['id' => null,
                'numeroIdentificacion' => 12345678,
                'nombre' => 'luis',
                'apellido' => 'gonzales',
                'telefono' => 111111,
                'correo'=> 'andersonduvanpaipa2002@gmail.com',
                'rol' => Rol::ADMINISTRADOR,
                'user'=>'diaz20',
                'contrasena' => 123456,
                'estado' => Estado::ACTIVO]

        );

        $Usuario->insert();
        $this->assertSame(true, $Usuario->usuarioRegistrado( 12345678));
    }

}
