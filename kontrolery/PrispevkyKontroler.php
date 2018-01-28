<?php

class PrispevkyKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s příspěvky
        $spravcePrispevku = new SpravcePrispevku();
        if (!empty($parametry[0]) && $parametry[0] == 'vymazat') {
            $spravcePrispevku->odstranPrispevek($parametry[1]);
            $this->pridejZpravu('Příspěvek byl úspěšně odstraněn');
            $this->presmeruj('prispevky/' . $parametry[2]);
        }
        // Získání příspěvků podle id přihlášeného uživatele
        $prispevky = $spravcePrispevku->zobrazPrispevkyUzivatele($parametry[0]);
        $iduzivatele = $spravcePrispevku->vratIdUzivatele2($parametry[0]);
        $this->data['iduzivatele'] = $iduzivatele;
        $this->data['prispevky'] = $prispevky;
        $this->pohled = 'prispevky';
    }

}
