<?php

// Správce uživatelů
class SpravceUzivatelu {

    // Vrátí otisk hesla
    public function vratOtisk($heslo) {
        $var = 'ByuT1S@w@';
        return hash('sha256', $heslo . $var);
    }

    // Registruje nového uživatele do systému
    public function registruj($jmeno, $heslo, $hesloZnovu, $jmeno_prijmeni, $email, $soucet) {
        if ($soucet != 7)
            throw new ChybaUzivatele('Chybně vyplněný antispam.');
        if ($heslo != $hesloZnovu)
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        if ($jmeno == '')
            throw new ChybaUzivatele('Nevyplněné jméno.');
        if ($jmeno_prijmeni == '')
            throw new ChybaUzivatele('Nevyplněné jméno.');
        $uzivatel = array(
            'jmeno' => $jmeno,
            'heslo' => $this->vratOtisk($heslo),
            'jmeno_prijmeni' => $jmeno_prijmeni,
            'email' => $email,
        );
        try {
            Db::vloz('uzivatel', $uzivatel);
        } catch (PDOException $chyba) {
            throw new ChybaUzivatele('Uživatel s tímto jménem je již zaregistrovaný.');
        }
    }

    // Přihlásí uživatele do systému
    public function prihlas($jmeno, $heslo) {
        $uzivatel = Db::dotazJeden('
                        SELECT id_uzivatel, jmeno, heslo, jmeno_prijmeni, typ
                        FROM uzivatel
                        WHERE jmeno = ? AND heslo = ?
                ', array($jmeno, $this->vratOtisk($heslo)));
        if (!$uzivatel)
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
        $_SESSION['uzivatel'] = $uzivatel;
    }

    // Odhlásí uživatele
    public function odhlas() {
        unset($_SESSION['uzivatel']);
    }

    //Vrátí údaje o uživateli podle jeho přihlašovacího jména
    public function vratIdUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_uzivatel`, `jmeno`, `jmeno_prijmeni`, `typ`
                        FROM `uzivatel`
                        WHERE `jmeno` = ?', array($uzivatel)
        );
    }

    //Funkce vráti údaje o uživatele podle jeho id
    public function vratIdUzivatele2($id_uzivatel) {
        $uzivatel = array(
            'id_uzivatel' => $id_uzivatel,
        );
        return Db::vyber('uzivatel', $uzivatel, 'WHERE `id_uzivatel` = ?', $uzivatel);
    }

    public function upravUzivatele($id_uzivatel, $jmeno, $jmeno_prijmeni, $email, $typ) {
        $euzivatel = array(
            'jmeno' => $jmeno,
            'jmeno_prijmeni' => $jmeno_prijmeni,
            'email' => $email,
            'typ' => $typ,
        );
        try {
            Db::uprav('uzivatel', $euzivatel, 'WHERE `id_uzivatel` = ?', array($id_uzivatel));
        } catch (PDOException $chyba) {
            throw new ChybaUzivatele('Nepodařilo se upravit záznam.');
        }
    }

    //Funkce pro odstranění uživatele
    public function odstranUzivatele($id_uzivatel) {
        Db::vymazZaznam('uzivatel', 'WHERE `id_uzivatel` = ?', array($id_uzivatel));
    }

    //Funkce vrátí seznam všech uživatelů
    public function zobrazUzivatele() {
        return Db::vyberVsechny('uzivatel');
    }

}
