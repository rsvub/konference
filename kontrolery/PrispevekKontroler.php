<?php

class PrispevekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $spravcePrispevku = new SpravcePrispevku();
        $this->hlavicka['titulek'] = 'Prispevek';
        if ($_POST) {
            try {
                $spravcePrispevku->vlozNovyPrispevek($parametry[0], $_POST['nazev'], $_POST['text'], $_POST['soubor'], $_POST['soubor'], $_POST['soucet']);
                $this->pridejZpravu('Příspěvek je úspěšně vložen.');
                $this->presmeruj('prispevky/' . $parametry[0]);
            } catch (ChybaPrispevek $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'prispevek';
    }

}
