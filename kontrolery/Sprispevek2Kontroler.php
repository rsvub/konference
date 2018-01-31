<?php

class Sprispevek2Kontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $spravcePrispevku = new SpravcePrispevku();
        $this->hlavicka['titulek'] = 'Správa příspěvku';
        $rprispevky = $spravcePrispevku->zobrazPrispevek($parametry[0]);
        $this->data['rprispevky'] = $rprispevky;
        $sprispevky = $spravcePrispevku->zobrazPrispevkyAdmin();
        $this->data['sprispevky'] = $sprispevky;
        if ($_POST) {
            try {
                $spravcePrispevku->vlozStav($parametry[0], $_POST['stav']);
                $this->pridejZpravu('Stav je úspěšně vložen.');
                $this->presmeruj('sprispevky/');
            } catch (ChybaPrispevek $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'sprispevek2';
    }

}
