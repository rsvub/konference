<?php

class PrihlaseniKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $spravceUzivatelu = new SpravceUzivatelu();
        //if ($spravceUzivatelu->vratUzivatele())
        //    $this->presmeruj('administrace');
        if (!empty($parametry[0]) && $parametry[0] == 'odhlasit') {
            $spravceUzivatelu->odhlas();
            $this->presmeruj('prihlaseni');
        }
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Přihlášení';
        if ($_POST) {
            try {
                $spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                $iduzivatele = $spravceUzivatelu->vratIdUzivatele($_POST['jmeno']);
                foreach ($iduzivatele as $iduzivatel)
                    ;
                $id_uzivatel = $iduzivatel['id_uzivatel'];
                if ($iduzivatel['typ'] == 'A') {
                    $this->presmeruj('uzivatele');
                } else {
                    $this->pridejZpravu('Byl jste úspěšně přihlášen.');
                    $this->presmeruj('prispevky/' . $id_uzivatel);
                }
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'prihlaseni';
    }

}
