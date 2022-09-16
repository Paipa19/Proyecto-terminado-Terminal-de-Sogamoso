<?php

namespace Tests\Unit\models;

use App\Enums\Estado;
use App\Models\Registros;
use PHPUnit\Framework\TestCase;


class HistoriasLaboralesTest extends TestCase
{

    public function testInsert()
    {
        $HistoriaLaboral = new Registros(['id' => null,
                    'numeroGaveta' => 1,
                    'numeroCarpetas'=>1,
                    'numeroFolios'=>38,
                    'documento'=>'1.057.587.806',
                    'numeroArchivador'=>4,
                    'nombre'=> 'INGRID TATIANA',
                    'apellido'=> 'SUAREZ BARRERA',
                    'cargo'=> 'AUXILIAR ADMINISTRATIVA',
                    'tipoVinculacion'=>'PLANTA',
                    'usuarios_id'=> 1,
                    'estado' =>Estado::INACTIVO,

            ]
        );
        $HistoriaLaboral->insert();
        $this->assertSame(true, $HistoriaLaboral->historiaLaboralRegistrado('1.057.587.806'));
    }

}


