<?php

class SpravcePrispevku {

    //Funkce pro zobrazení všch článků od přihlášeného uživatele
    public function zobrazPripevkyUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`
                        FROM `prispevek`
                        WHERE `id_autor` = ?', array($uzivatel)
        );
    }

}
