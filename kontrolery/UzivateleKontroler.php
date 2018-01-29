<?php

class UzivateleKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravceUzivatelu = new SpravceUzivatelu();

        // Získání příspěvků podle id přihlášeného uživatele
        $uzivatele = $spravceUzivatelu->zobrazUzivatele();
        $this->data['uzivatele'] = $uzivatele;
        $this->pohled = 'uzivatele';
    }

}