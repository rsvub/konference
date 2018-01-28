<?php

class SpravcePrispevku {

    //Nový příspěvek do systému
    public function vlozNovyPrispevek($id_autor, $nazev, $text, $soubor, $soucet) {
        if ($soucet != 7)
            throw new ChybaPrispevek('Chybně vyplněný antispam.');
        //$soubor = fopen($file, 'rb');
        $prispevek = array(
            'id_autor' => $id_autor,
            'nazev' => $nazev,
            'text' => $text,
            'soubor' => $soubor,
        );
        try {
            Db::vloz('prispevek', $prispevek);
        } catch (PDOException $chyba) {
            throw new ChybaPrispevek('Nepodarilo se vlozit prispevek.');
        }
    }

    //Nový příspěvek do systému
    public function editujPrispevek($id_prispevek, $id_autor, $nazev, $text, $soubor, $soucet) {
        if ($soucet != 7)
            throw new ChybaPrispevek('Chybně vyplněný antispam.');
        //$soubor = fopen($file, 'rb');
        $eprispevek = array(
            'id_prispevek' => $id_prispevek,
            'id_autor' => $id_autor,
            'nazev' => $nazev,
            'text' => $text,
            'soubor' => $soubor,
        );
        try {
            Db::zmen('prispevek', $eprispevek);
        } catch (PDOException $chyba) {
            throw new ChybaPrispevek('Nepodarilo se vlozit prispevek.');
        }
    }

    //Funkce pro zobrazení všch článků od přihlášeného uživatele
    public function zobrazPrispevkyUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`, `id_autor`, `jmeno`,`jmeno_prijmeni`, `stav`,`hodnoceni`, `id_uzivatel`
                        FROM `uzivatel`, `prispevek`
                        WHERE `id_autor` = `id_uzivatel`
                        AND `id_uzivatel` = ?', array($uzivatel)
        );
    }

    public function zobrazPrispevek($id_prispevek) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`, `id_autor`
                        FROM `prispevek`
                        WHERE `id_prispevek` = ?', array($id_prispevek)
        );
    }

    //Funkce pro odstranění příspěvku
    public function odstranPrispevek($id_prispevek) {
        Db::dotaz('
			DELETE FROM prispevek
			WHERE id_prispevek = ?
		', array($id_prispevek));
    }

    public function vratIdUzivatele2($id_uzivatel) {
        $uzivatel = array(
            'id_uzivatel' => $id_uzivatel,
        );
        return Db::vyber('uzivatel', $uzivatel, 'WHERE `id_uzivatel` = ?', $uzivatel);
    }

}
