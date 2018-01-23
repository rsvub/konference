<?php

class PrispevkyKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravcePrispevku = new SpravcePrispevku();

        // Získání příspěvků podle id přihlášeného uživatele
        $prispevky = $spravcePrispevku->zobrazPrispevkyUzivatele($parametry[0]);
        $this->data['prispevky'] = $prispevky;
        $this->pohled = 'prispevky';
    }

}
