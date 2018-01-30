<?php

class SpravcePrispevku {

    //Nový příspěvek do systému
    public function vlozNovyPrispevek($id_autor, $nazev, $text, $soubor, $soubor_nazev, $jmeno_autor, $soucet) {
        if ($soucet != 7)
            throw new ChybaPrispevek('Chybně vyplněný antispam.');
        //$soubor = fopen($file, 'rb');
        $prispevek = array(
            'id_autor' => $id_autor,
            'nazev' => $nazev,
            'text' => $text,
            'soubor' => $soubor,
            'soubor_nazev' => $soubor_nazev,
            'jmeno_autor' => $jmeno_autor,
        );
        try {
            Db::vloz('prispevek', $prispevek);
        } catch (PDOException $chyba) {
            throw new ChybaPrispevek('Nepodarilo se vlozit prispevek.');
        }
    }

    //Úprava příspěvku v systému
    public function editujPrispevek($id_prispevek, $id_autor, $nazev, $text, $soubor, $soubor_nazev, $jmeno_autor, $soucet) {
        if ($soucet != 7)
            throw new ChybaPrispevek('Chybně vyplněný antispam.');
        //$soubor = fopen($file, 'rb');
        $eprispevek = array(
            'id_prispevek' => $id_prispevek,
            'id_autor' => $id_autor,
            'nazev' => $nazev,
            'text' => $text,
            'soubor' => $soubor,
            'soubor_nazev' => $soubor_nazev,
            'jmeno_autor' => $jmeno_autor,
        );
        try {
            Db::zmen('prispevek', $eprispevek);
        } catch (PDOException $chyba) {
            throw new ChybaPrispevek('Nepodarilo se vlozit prispevek.');
        }
    }

    //Funkce založí záznam pro recenzenta do tabulky recenzent
    public function vlozRecenzentPrispevek($id_rprispevek, $id_recenzent) {
        $sprispevek = array(
            'id_rprispevek' => $id_rprispevek,
            'id_recenzent' => $id_recenzent,
        );
        try {
            Db::vloz('recenze', $sprispevek);
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

    public function zobrazRecenzeUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`, `id_autor`, `jmeno_autor`, `stav`,`hodnoceni`
                        FROM `recenze`, `prispevek`
                        WHERE `id_autor` = `id_recenzent`
                        AND `id_autor` = ?', array($uzivatel)
        );
    }

    //Fuinkce vrátí data jednoho příspěvku podle id příspěvku
    public function zobrazPrispevek($id_prispevek) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`, `id_autor`, `jmeno_autor`
                        FROM `prispevek`
                        WHERE `id_prispevek` = ?', array($id_prispevek)
        );
    }

    //Funkce pro odstranění příspěvku
    public function odstranPrispevek($id_prispevek) {
        Db::vymazZaznam('prispevek', 'WHERE `id_prispevek` = ?', array($id_prispevek));
    }

    //Funkce vrátí údaje o uživateli podle id uživatele
    public function vratIdUzivatele2($id_uzivatel) {
        $uzivatel = array(
            'id_uzivatel' => $id_uzivatel,
        );
        return Db::vyber('uzivatel', $uzivatel, 'WHERE `id_uzivatel` = ?', $uzivatel);
    }

    //Funkce vrátí údaje o uživateli podle id uživatele
    public function vratIdUzivatele() {
        $uzivatel = array(
            'id_uzivatel' => 1,
        );
        return Db::vyber('uzivatel', $uzivatel, 'WHERE `typ` = ?', array('R'));
    }

    //Funkce vrátí seznam všech uživatelů
    public function zobrazPrispevky() {
        return Db::vyberVsechny('prispevek');
    }

}
