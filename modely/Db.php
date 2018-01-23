<?php

class Db {

    private static $spojeni;
    //Nastavení pro PDO funkci připojení databáze
    private static $nastaveni = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    //PDO funkce připojení
    public static function pripoj($host, $uzivatel, $heslo, $databaze) {
        if (!isset(self::$spojeni)) {
            self::$spojeni = @new PDO(
                    "mysql:host=$host;dbname=$databaze", $uzivatel, $heslo, self::$nastaveni
            );
        }
    }

    //Funkce pro volání jednoho řádku z databáze
    public static function dotazJeden($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
    }

    //Funkce pro výpis všech vyhovujících záznamů z databáze
    public static function dotazVsechny($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }
    
    //Funkce pro vložení záznamu do tabulky
    public static function vloz($tabulka, $parametry = array()) {
        return self::dotaz("INSERT INTO `$tabulka` (`" .
                        implode('`, `', array_keys($parametry)) .
                        "`) VALUES (" . str_repeat('?,', sizeOf($parametry) - 1) . "?)", array_values($parametry));
    }

}
