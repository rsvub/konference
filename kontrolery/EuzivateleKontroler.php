<?php

class EuzivateleKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Správa uživatele';
        $spravceUzivatelu = new SpravceUzivatelu();
        $euzivatele = $spravceUzivatelu->vratIdUzivatele2($parametry[0]);
        $this->data['euzivatele'] = $euzivatele;
        if ($_POST) {
            try {
                $spravceUzivatelu->upravUzivatele($parametry[0], $_POST['jmeno'], $_POST['jmeno_prijmeni'], $_POST['email'], $_POST['typ']);
                $this->pridejZpravu('Uživatel je úspěšně vložen.');
                $this->presmeruj('uzivatele/');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'euzivatele';
    }

}