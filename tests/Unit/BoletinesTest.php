<?php

namespace Tests\Unit\models;

use App\Enums\Estado;
use App\Models\Ingresos;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class BoletinesTest extends TestCase
{

    public function testInsert()
    {
        $Boletin= new Ingresos(['id' => null,
                'numeroBoletin1'=>24,
                'numeroBoletin2'=>25,
                'fecha' => Carbon::parse('02-12-21')->format('d-m-Y'),
                'nombreBeneficiario' => 'Terminal',
                'numeroRecibo1'=>5,
                'numeroRecibo2'=>6,
                'descripcion'=>'prueba',
                'estado' =>Estado::ACTIVO,
                'usuarios_id'=> 1,
                'archivos_id'=> 1,


            ]
        );
        $Boletin->insert();
        $this->assertSame(true, $Boletin->boletinRegistrado(24));
    }

}


