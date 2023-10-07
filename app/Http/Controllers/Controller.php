<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static $LOCALE_PT_BR = 'pt-br';
    public static $LOCALE_EN = 'en';
    public static $LOCALE_ES = 'es';

    public function localeKey() {
        switch (app()->getLocale()) {
            case self::$LOCALE_PT_BR:
                return 'pt-BR';
                break;
            
            case self::$LOCALE_EN:
                return 'en-GB';
                break;

            case self::$LOCALE_ES:
                return 'es-ES';
                break;

            default:
                return 'pt-BR';
                break;
        }
    }
}
