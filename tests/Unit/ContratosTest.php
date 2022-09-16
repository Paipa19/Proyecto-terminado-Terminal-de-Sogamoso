<?php

namespace Tests\Unit\models;

use App\Enums\Estado;
use App\Models\Contratos;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class ContratosTest extends TestCase
{

    public function testInsert()
    {
        $Contrato = new Contratos(['id' => null,
                'numContrato' => 2,
                'fecha' =>  Carbon::now()->subYear(12)->format('Y-m-d'),
                'estado' =>Estado::ACTIVO,
                'beneficiarios_id'=> 1,

            ]
        );
        $Contrato->insert();
        $this->assertSame(true, $Contrato->contratoRegistrado(2));
    }

}