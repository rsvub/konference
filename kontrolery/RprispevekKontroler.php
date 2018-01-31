<?php

class RprispevekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $spravcePrispevku = new SpravcePrispevku();
        if (!empty($parametry[0]) && $parametry[0] == 'stahnout') {
            $spravcePrispevku->stahniPrispevek($parametry[1]);
            $this->presmeruj('rprispevek/' . $parametry[1]);
        }
        $rprispevek = $spravcePrispevku->zobrazPrispevek($parametry[0]);
        $this->data['rprispevek'] = $rprispevek;
        if ($_POST) {
            try {
                $id = array($parametry[0], $parametry[1]);
                $spravcePrispevku->vlozPosudek($id, $_POST['poznamka'], $_POST['ciselnik_originalita'], $_POST['ciselnik_tema'], $_POST['ciselnik_doporuceni']);
                $hodnoceni = $spravcePrispevku->spoctiHodnoceni($id);
                $spravcePrispevku->vlozHodnoceni($id, $hodnoceni['vysledek']);
                $this->pridejZpravu('Hodnocení: ' . $hodnoceni['vysledek']);
                $this->pridejZpravu('Posudek je úspěšně vložen.');
                $this->presmeruj('recenze/' . $parametry[1]);
            } catch (ChybaPrispevek $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'rprispevek';
    }

}
