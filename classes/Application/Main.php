<?php

namespace Application; // Definicja przestrzeni nazw Application, aby uniknąć konfliktów nazw z innymi kodami.

class Main { // Klasa główna `Main` służy do zarządzania konfiguracją aplikacji, stylami, skryptami i obiektami.

    public $cmd; // Pole do przechowywania przekazanego polecenia w postaci tablicy.
    public $config; // Pole do przechowywania konfiguracji aplikacji.
    public $objects = []; // Tablica do przechowywania zarejestrowanych obiektów.

    public function __construct($cmd, $config){ 
        // Konstruktor, który inicjalizuje klasę. Przyjmuje dwa argumenty: 
        // - `$cmd`: ciąg znaków z poleceniem, który jest dzielony na części za pomocą `/`.
        // - `$config`: tablica konfiguracji aplikacji.
        $this->cmd = explode("/",$cmd);
        $this->config = $config;
    } 

    public function ObjectRegister(&$obj){
        // Metoda do rejestrowania obiektów w tablicy `$objects`.
        if (is_object($obj)){ // Sprawdza, czy przekazany argument jest obiektem.
            $this->objects[get_class($obj)] = $obj; // Dodaje obiekt do tablicy z kluczem będącym nazwą klasy.
        }
        return false; // Zwraca `false`, jeśli argument nie jest obiektem.
    }

    public function GetInstance($ClassName){
        // Metoda zwraca instancję obiektu zarejestrowanego w tablicy `$objects`.
        if (array_key_exists($ClassName,$this->objects)){ // Sprawdza, czy obiekt istnieje.
            return $this->objects[$ClassName]; // Zwraca instancję obiektu.
        }
        return false; // Zwraca `false`, jeśli obiekt nie istnieje.
    }

    public function isTemplateExists($file){
        // Metoda sprawdzająca, czy plik szablonu istnieje.
        $path = "templates/".$this->config['template']."/".$file; 
        if (file_exists($path)){ // Używa funkcji `file_exists` do sprawdzenia istnienia pliku.
            return true; // Zwraca `true`, jeśli plik istnieje.
        }
        return false; // Zwraca `false`, jeśli plik nie istnieje.
    }

    public function IncludePath($file){
        // Metoda zwracająca ścieżkę do pliku szablonu.
       $path = "templates/".$this->config['template']."/".$file; 
       return $path;
    }

    public function AddStyle($name){
        // Metoda dodająca nazwę arkusza stylów do konfiguracji CSS.
        $this->config['css'][] = $name;
    }

    public function AddJava($name){
        // Metoda dodająca nazwę pliku JavaScript do konfiguracji JS.
        $this->config['js'][] = $name;
    }

    public function LoadCss(){
        // Metoda generująca znaczniki `<link>` dla wszystkich stylów CSS.
        $url = $this->config['proto']."://".$this->config['url']."/templates/".
               $this->config['template']."/css/"; // Tworzy URL bazowy dla stylów CSS.
        if (count($this->config['css'])>0){ // Sprawdza, czy istnieją dodane style CSS.
           $html=''; 
            foreach($this->config['css'] as $w){ // Iteruje przez style.
               $html .= "<link rel='StyleSheet' type='text/css' href='{$url}{$w}' >\n";     
            }           
           return $html; // Zwraca wygenerowany kod HTML.
        }       
        return false; // Zwraca `false`, jeśli brak stylów do załadowania.
    }

    public function LoadJava(){
        // Metoda generująca znaczniki `<script>` dla wszystkich plików JavaScript.
        $url = $this->config['proto']."://".$this->config['url']."/templates/".
               $this->config['template']."/js/"; // Tworzy URL bazowy dla plików JS.
        if (count($this->config['js'])>0){ // Sprawdza, czy istnieją dodane pliki JS.
           $html='';
            foreach($this->config['js'] as $w){ // Iteruje przez pliki JS.
               $html .= "<script src='{$url}{$w}' ></script>\n";     
            }           
           return $html; // Zwraca wygenerowany kod HTML.
        }       
        return false; // Zwraca `false`, jeśli brak skryptów do załadowania.
    }

    public function GetImg($name) {
        // Metoda zwracająca pełny URL do obrazu z folderu `gfx`.
        $url = $this->config['proto']."://".$this->config['url']."/templates/".
               $this->config['template']."/gfx/".$name;
        return $url;
    }

    public function GetUrl($PageUrl) {
        // Metoda zwracająca pełny URL do strony w formacie HTML.
        $url = $this->config['proto']."://".$this->config['url'].$PageUrl.".html";
        return $url;
    }
}
