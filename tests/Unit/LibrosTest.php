<?php

namespace Tests\Unit\models;

use App\Enums\Estado;
use App\Models\Libros;
use PHPUnit\Framework\TestCase;

class LibrosTest extends TestCase
{

    public function testInsert()
    {
        $Libro = new Libros(['id' => null,
                'estanteLibro' => 1,
                'nivelLibro' => 2,
                'cantidad'=> 10,
                'numBoletin'=>21,
                'numComprobante'=>34,
                'mes1'=>'Abril',
                'mes2'=>'No hay',
                'agenda'=>'2022',
                'estado' =>Estado::ACTIVO,
                'usuarios_id'=>1,
            ]
        );
        $Libro->insert();
        $this->assertSame(true,$Libro->libroRegistrado(28));
    }

}