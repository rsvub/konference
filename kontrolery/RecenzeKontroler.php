<?php

class RecenzeKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravcePrispevku = new SpravcePrispevku();
        $recenzenti = $spravcePrispevku->vratIdUzivatele2($parametry[0]);
        $this->data['recenzenti'] = $recenzenti;
        $this->hlavicka['titulek'] = 'Seznam recenzí';

        // Získání příspěvků podle id přihlášeného uživatele
        $prispevky = $spravcePrispevku->zobrazRecenzeUzivatele($parametry[0]);
        $this->data['prispevky'] = $prispevky;
        $this->pohled = 'recenze';
    }

}
