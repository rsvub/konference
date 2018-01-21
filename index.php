<?php


//Nastavení interního kódování
mb_internal_encoding("UTF-8");

//Funkce pro automatické načítání tříd
function autoloadFunkce($trida)
{
	// Končí název třídy řetězcem "Controller" ?
    if (preg_match('/Kontroler$/', $trida))	
        require("kontrolery/" . $trida . ".php");
    else
        require("modely/" . $trida . ".php");
}

// Registrace funkce
spl_autoload_register("autoloadFunkce");

// Vytvoření routeru a zpracování parametrů od uživatele z URL
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));

//Vytvoření šablony
$smerovac->vypisPohled();