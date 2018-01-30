<?php

class SprispevekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $spravcePrispevku = new SpravcePrispevku();
        $this->hlavicka['titulek'] = 'Správa příspěvku';
        $recenzenti = $spravcePrispevku->vratIdUzivatele($parametry[0]);
        $this->data['recenzenti'] = $recenzenti;
        $rprispevky = $spravcePrispevku->zobrazPrispevek($parametry[0]);
        $this->data['rprispevky'] = $rprispevky;
        if (!empty($parametry[0]) && $parametry[0] == 'vlozRecenzenta') {
            try {
                $spravcePrispevku->vlozRecenzentPrispevek($parametry[2], $parametry[1]);
                $spravcePrispevku->upravUziv();
                $this->pridejZpravu('Recenzent je úspěšně vložen.');
                $this->presmeruj('sprispevky/');
            } catch (ChybaPrispevek $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'sprispevek';
    }

}
