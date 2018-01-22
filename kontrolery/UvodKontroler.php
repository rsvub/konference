<?php

class UvodKontroler extends Kontroler
{
        public function zpracuj($parametry)
        {
                $this->hlavicka = array(
                        'titulek' => 'Webová konference',
                        'klicova_slova' => 'web, konference',
                        'popis' => 'Semestrální práce z předmětu KIV/WEB.'
                );

                $this->pohled = 'uvod';
    }
}