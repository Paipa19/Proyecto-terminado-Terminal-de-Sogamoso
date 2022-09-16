<?php

namespace App\Enums;

use phpDocumentor\Reflection\Types\Self_;

Enum Rol: string
{


    case ADMINISTRADOR="Administrador";
    case AUXILIAR="Auxiliar";



    public function toString(): string
    {
        return match ($this) {
            self::ADMINISTRADOR => "Administrador",
            self::AUXILIAR=>"Auxiliar",

        };

   }

}