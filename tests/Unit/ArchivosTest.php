<?php

namespace Tests\Unit\models;

use App\Enums\Estado;
use App\Models\Archivos;
use PHPUnit\Framework\TestCase;

class ArchivosTest extends TestCase
{

    public function testInsert()
    {
        $Archivo = new Archivos(['id' => null,
                'numFolios' => 2,
                'numEstante' => 2,
                'nivelEstante'=> 1,
                'numCaja'=>5,
                'numCarpeta'=>3,
                'estado' =>Estado::ACTIVO,

            ]
        );
        $Archivo->insert();
        $this->assertSame(true, $Archivo->archivoRegistrado(1));
    }

}

