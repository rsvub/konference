<?php

class SprispevkyKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravcePrispevku = new SpravcePrispevku();
        $this->hlavicka['titulek'] = 'Seznam příspěvků';
        if (!empty($parametry[0]) && $parametry[0] == 'vymazat') {
            $spravcePrispevku->odstranPrispevek($parametry[1]);
            $this->pridejZpravu('Příspěvek byl úspěšně odstraněn');
            $this->presmeruj('sprispevky/');
        }
        // Získání příspěvků
        $sprispevky = $spravcePrispevku->zobrazPrispevky();
        $this->data['sprispevky'] = $sprispevky;
        $this->pohled = 'sprispevky';
    }

}