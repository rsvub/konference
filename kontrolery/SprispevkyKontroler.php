<?php

class SprispevkyKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravcePrispevku = new SpravcePrispevku();
        $this->hlavicka['titulek'] = 'Seznam příspěvků';

        // Získání příspěvků
        $sprispevky = $spravcePrispevku->zobrazPrispevkyAdmin();
        $this->data['sprispevky'] = $sprispevky;
        $this->pohled = 'sprispevky';
    }

}