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

    //Vrátí Id uiživatele
    public function vratIdUzivatele($uzivatel) {
        return Db::dotazVsechny('
                        SELECT `id_uzivatel`, `jmeno`, `jmeno_prijmeni`, `typ`
                        FROM `uzivatel`
                        WHERE `jmeno` = ?', array($uzivatel)
        );
    }

    public function zobrazUzivatele() {
        return Db::vyberVsechny('uzivatel');
    }

    // Zjistí, zda je přihlášený uživatel administrátor
    public function vratUzivatele() {
        if (isset($_SESSION['uzivatel']))
            return $_SESSION['uzivatel'];
        return null;
    }

}
