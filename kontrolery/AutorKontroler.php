<?php

class AutorKontroler extends Kontroler
{
        public function zpracuj($parametry)
        {
                $this->hlavicka = array(
                        'titulek' => 'Pokyny autorům',
                        'klicova_slova' => 'autor, konference',
                        'popis' => 'Pokyny autorům pro užívání systému Webové konference.'
                );

                $this->pohled = 'autor';
    }
}