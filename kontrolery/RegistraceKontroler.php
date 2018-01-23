<?php

class RegistraceKontroler extends Kontroler
{
        public function zpracuj($parametry)
        {
                $this->hlavicka = array(
                        'titulek' => 'Registrace',
                        'klicova_slova' => 'web, konference',
                        'popis' => 'Ragistrace do systému Webové konference.'
                );

                $this->pohled = 'registrace';
    }
}
