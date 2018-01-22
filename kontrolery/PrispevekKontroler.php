<?php

class PrispevekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravcePrispevku = new SpravcePrispevku();

        // Získání příspěvků podle id přihlášeného uživatele
        $prispevky = $spravcePrispevku->zobrazPripevkyUzivatele($parametry[1]);
        $this->data['prispevky'] = $prispevky;
        $this->pohled = 'prispevky';
    }

}
