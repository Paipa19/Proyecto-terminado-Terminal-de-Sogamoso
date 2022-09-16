<?php

namespace App\Enums;

enum Estado: String
{

    case ACTIVO = 'Activo';
    case INACTIVO = 'Inactiva';

    public  function toString(): string
    {

        return match ($this) {
            self::ACTIVO =>'Activo',
            self::INACTIVO=>'Inactiva',
        };
    }
}