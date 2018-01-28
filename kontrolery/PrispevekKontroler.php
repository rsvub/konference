<?php

class PrispevekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Prispevek';
        if ($_POST) {
            try {
                $spravcePrispevku = new SpravcePrispevku();
                //$soubor_cesta = $_FILES['soubor']['name'];
                $spravcePrispevku->vlozNovyPrispevek($parametry[0], $_POST['nazev'], $_POST['text'], $_POST['soubor'], $_POST['soucet']);
                $this->pridejZpravu('Příspěvek je úspěšně vložen.');
                $this->presmeruj('prispevky/' . $parametry[0]);
            } catch (Prispevek $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'prispevek';
    }

}
