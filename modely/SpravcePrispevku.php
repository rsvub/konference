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

    //Funkce vloží posudek k příspěvku
    public function vlozPosudek($id, $poznamka, $ciselnik_originalita, $ciselnik_tema, $ciselnik_doporuceni) {
        $sprispevek = array(
            'poznamka' => $poznamka,
            'ciselnik_originalita' => $ciselnik_originalita,
            'ciselnik_tema' => $ciselnik_tema,
            'ciselnik_doporuceni' => $ciselnik_doporuceni,
        );
        try {
            Db::uprav('recenze', $sprispevek, 'WHERE `id_rprispevek` = ? AND `id_recenzent` = ?', $id);
        } catch (PDOException $chyba) {
            throw new ChybaPrispevek('Nepodařilo se upravit záznam.');
        }
    }
    
        //Funkce vloží posudek k příspěvku
    public function vlozHodnoceni($id, $hodnoceni) {
        $sprispevek = array(
            'hodnoceni' => $hodnoceni,
        );
        try {
            Db::uprav('recenze', $sprispevek, 'WHERE `id_rprispevek` = ? AND `id_recenzent` = ?', $id);
        } catch (PDOException $chyba) {
            throw new ChybaPrispevek('Nepodařilo se upravit záznam.');
        }
    }

    public function upravUziv() {
        return Db::dotaz('UPDATE uzivatel SET typ = "R" WHERE typ = "R"');
    }

    //Funkce pro zobrazení všch článků od přihlášeného uživatele
    public function zobrazPrispevkyUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`, `id_autor`, `jmeno`,`jmeno_prijmeni`, `stav`,`hodnoceno`, `id_uzivatel`
                        FROM `uzivatel`, `prispevek`
                        WHERE `id_autor` = `id_uzivatel`
                        AND `id_uzivatel` = ?', array($uzivatel)
        );
    }

    public function zobrazRecenzeUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `datum`, `nazev`, `text`, `hodnoceni`, `id_recenzent`
                        FROM `recenze`, `prispevek`
                        WHERE `id_rprispevek` = `id_prispevek`
                        AND `id_recenzent` = ?', array($uzivatel)
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

    //Funkce vrátí hodnocení konkrétního příspěvku
    public function spoctiHodnoceni($id) {
        return Db::dotazJeden('
                        SELECT (`ciselnik_originalita` + `ciselnik_tema` + `ciselnik_doporuceni`)/3 AS vysledek
                        FROM `recenze`
                        WHERE `id_rprispevek` = ? AND `id_recenzent` = ?', $id
        );
    }

    public function stahniPrispevek($id_prispevek) {
        $gotten = @mysqli_query("select * from prispevek where id_prispevek = . $id_prispevek");
        $row = @mysqli_fetch_array($gotten);
        $bytes = $row['soubor'];
        header("Content-type: application/pdf");
        header('Content-disposition: attachment; filename="thing.pdf"');
        print $bytes;
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

    //Funkce vrátí údaje o uživateli podle id prispevku
    public function vratIdUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_prispevek`, `nazev`, `jmeno_autor`, `id_uzivatel`, `jmeno_prijmeni`
                        FROM `uzivatel`, `prispevek`
                        WHERE `typ` = "R"
                        AND `id_prispevek` = ?', array($uzivatel)
        );
    }

    //Funkce vrátí seznam všech uživatelů
    public function zobrazPrispevky() {
        return Db::vyberVsechny('prispevek');
    }

    public function zobrazPrispevkyAdmin() {
        return Db::dotazVsechny('
                        SELECT `nazev`, `jmeno_autor`, `datum`, `id_prispevek`, `stav`, `jmeno_recenzent` 
                        FROM `prispevek` LEFT JOIN `recenze` ON `id_prispevek`=`id_rprispevek` ORDER BY `datum` DESC'
        );
    }

    public function upload() {
        
    }

}
