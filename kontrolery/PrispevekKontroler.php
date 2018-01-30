<?php

class PrispevekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $spravcePrispevku = new SpravcePrispevku();
        $uzivatele = $spravcePrispevku->vratIdUzivatele2($parametry[0]);
        $this->data['uzivatele'] = $uzivatele;        
        $this->hlavicka['titulek'] = 'Prispevek';
        if ($_POST) {
            try {
                $spravcePrispevku->vlozNovyPrispevek($parametry[0], $_POST['nazev'], $_POST['text'], $_POST['soubor'], $_POST['soubor'], $_POST['jmeno_autor'], $_POST['soucet']);
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
