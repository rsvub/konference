<?php

// Výchozí kontroler pro Konferenci
abstract class Kontroler {

    // Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné
    protected $data = array();
    // Název šablony bez přípony
    protected $pohled = "";
    // Hlavička HTML stránky
    protected $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => '');

    // Vyrenderuje pohled
    public function vypisPohled() {
        if ($this->pohled) {
            extract($this->osetri($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("pohledy/" . $this->pohled . ".phtml");
        }
    }

    // Přesměruje na dané URL
    public function presmeruj($url) {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    // Hlavní metoda controlleru
    abstract function zpracuj($parametry);

    // Ošetření proti cross-site scriptingu
    private function osetri($x = null) {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x)) {
            foreach ($x as $k => $v) {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        } else
            return $x;
    }

    public function pridejZpravu($zprava) {
        if (isset($_SESSION['zpravy']))
            $_SESSION['zpravy'][] = $zprava;
        else
            $_SESSION['zpravy'] = array($zprava);
    }

    public static function vratZpravy() {
        if (isset($_SESSION['zpravy'])) {
            $zpravy = $_SESSION['zpravy'];
            unset($_SESSION['zpravy']);
            return $zpravy;
        } else
            return array();
    }

}
