<?php

class EprispevekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $spravcePrispevku = new SpravcePrispevku();
        $eprispevek = $spravcePrispevku->zobrazPrispevek($parametry[0]);
        $this->data['eprispevek'] = $eprispevek;
        $this->hlavicka['titulek'] = 'Editace příspěvku';
        if ($_POST) {
            try {
                //$soubor_cesta = $_FILES['soubor']['name'];
                $spravcePrispevku->editujPrispevek($parametry[0], $parametry[1], $_POST['nazev'], $_POST['text'], $_POST['soubor'], $_POST['soubor'], $_POST['soucet']);
                $this->pridejZpravu('Příspěvek je úspěšně vložen.');
                $this->presmeruj('prispevky/' . $parametry[1]);
            } catch (Prispevek $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'eprispevek';
    }

}
