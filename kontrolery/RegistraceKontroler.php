<?php

class RegistraceKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
                // Hlavička stránky
                $this->hlavicka['titulek'] = 'Registrace';
                if ($_POST)
                {
                        try
                        {
                                $spravceUzivatelu = new SpravceUzivatelu();
                                $spravceUzivatelu->registruj($_POST['jmeno'], $_POST['heslo'], $_POST['heslo_znovu'], $_POST['jmeno_prijmeni'], $_POST['email'], $_POST['soucet']);
                                //$spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                                $this->pridejZpravu('Byl jste úspěšně zaregistrován.');
                                $this->presmeruj('prihlaseni');
                        }
                        catch (ChybaUzivatele $chyba)
                        {
                                $this->pridejZpravu($chyba->getMessage());
                        }
                }
                // Nastavení šablony
                $this->pohled = 'registrace';
    }
}