<?php

class PrihlaseniKontroler extends Kontroler
{
        public function zpracuj($parametry)
        {
                $this->hlavicka = array(
                        'titulek' => 'Přihlášení - Webová konference',
                        'klicova_slova' => 'web, konference',
                        'popis' => 'Přihlášení do systému Webové konference.'
                );

                $this->pohled = 'prihlaseni';
    }
}
