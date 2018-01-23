<?php

class SpravcePrispevku {

    //Funkce pro zobrazení všch článků od přihlášeného uživatele
    public function zobrazPrispevkyUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`, `jmeno_prijmeni`
                        FROM `uzivatel`, `prispevek`
                        WHERE `id_autor` = `id_uzivatel`
                        AND `id_autor` = ?', array($uzivatel)
        );
    }

}
