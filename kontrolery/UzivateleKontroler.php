<?php

class UzivateleKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravceUzivatelu = new SpravceUzivatelu();
        if (!empty($parametry[0]) && $parametry[0] == 'vymazat') {
            $spravceUzivatelu->odstranUzivatele($parametry[1]);
            $this->pridejZpravu('Uživatel byl úspěšně odstraněn');
            $this->presmeruj('uzivatele/');
        }

        // Získání příspěvků podle id přihlášeného uživatele
        $uzivatele = $spravceUzivatelu->zobrazUzivatele();
        $this->data['uzivatele'] = $uzivatele;
        $this->pohled = 'uzivatele';
    }

}
