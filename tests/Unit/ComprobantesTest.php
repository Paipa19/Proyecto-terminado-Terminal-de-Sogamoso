<?php

namespace Tests\Unit\models;

use App\Enums\Estado;
use App\Models\Comprobantes;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class ComprobantesTest extends TestCase
{

    public function testInsert()
    {
        $Comprobante= new Comprobantes(['id' => null,
                'numeroComprobante' => 1,
                'fecha' => Carbon::parse('02-12-21')->format('d-m-Y'),
                'descripcion'=>'Comprobante de prueba',
                'estado' =>Estado::ACTIVO,
                'usuarios_id'=> 1,
                'contratos_id'=> 1,
                'archivos_id'=> 1,


            ]
        );
        $Comprobante->insert();
        $this->assertSame(true, $Comprobante->comprobanteRegistrado(1));
    }

}

