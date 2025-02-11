<?php

namespace App\services;

use voku\helper\AntiXSS;

class VokuAntiXss implements OwnAntixssInterface
{
    
    public function __construct(private AntiXSS $antiXSS)
    {
        
    }


    public function clean(string $string): string 
    {
        return $this->antiXSS->xss_clean($string);

    }
}
