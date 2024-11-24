<?php
// Controller.php

namespace Application; // Definicja przestrzeni nazw Application, aby uniknąć konfliktów nazw.

class Controller { // Klasa `Controller` służy do obsługi poleceń aplikacji, przekierowań i parametrów.

    private $cmd; // Prywatne pole przechowujące przekazane polecenie w postaci tablicy.
    private $config; // Prywatne pole przechowujące konfigurację aplikacji.

    public function __construct($cmd, $config){
        // Konstruktor inicjalizujący klasę. Przyjmuje dwa argumenty:
        // - `$cmd`: ciąg znaków reprezentujący polecenie (np. ścieżka akcji).
        // - `$config`: tablica zawierająca konfigurację aplikacji.
        $this->cmd = explode("/",$cmd); // Polecenie jest dzielone na elementy przy użyciu `/`.
        $this->config = $config; // Konfiguracja jest przechowywana w prywatnym polu.
    }

    public function GetObjectName(){
        // Metoda zwracająca pełną nazwę klasy na podstawie pierwszych dwóch elementów polecenia.
        if (isset($this->cmd[0]) && isset($this->cmd[1])){ 
            // Sprawdza, czy pierwsze dwa elementy polecenia są ustawione.
            $ObjectName = "\\".$this->cmd[0]."\\".$this->cmd[1]; 
            // Tworzy nazwę klasy w formacie `\Namespace\ClassName`.
            if (class_exists($ObjectName)){ 
                // Sprawdza, czy klasa o tej nazwie istnieje.
                return $ObjectName; // Zwraca pełną nazwę klasy.
            }
        }   
        return false; // Zwraca `false`, jeśli klasa nie istnieje lub polecenie jest nieprawidłowe.
    }

    public function RedirectPage($PageUrl, $end = 0){
        // Metoda przekierowująca użytkownika na podaną stronę.
        // - `$PageUrl`: adres strony do przekierowania (bez `.html`).
        // - `$end`: jeśli wynosi `1`, wykonanie skryptu zostaje zatrzymane po przekierowaniu.
        $url = $this->config['proto']."://".$this->config['url'].$PageUrl.".html";
        // Tworzy pełny URL do strony, korzystając z konfiguracji aplikacji.
        header("Location: {$url}"); 
        // Ustawia nagłówek HTTP do przekierowania użytkownika na podany adres.
        if ($end == 1){
            die(); // Zatrzymuje dalsze wykonanie skryptu, jeśli `$end` jest równe `1`.
        }
    }

    public function GetParam($name){
        // Metoda pobierająca wartość parametru z polecenia.
        // - `$name`: nazwa parametru do wyszukania.
        $key = array_search($name, $this->cmd); 
        // Szuka indeksu elementu o nazwie `$name` w tablicy `$cmd`.
        if ($key){ 
            // Sprawdza, czy parametr został znaleziony.
            if (isset($this->cmd[$key + 1])){ 
                // Sprawdza, czy istnieje element następujący po parametrze.
                return $this->cmd[$key + 1]; 
                // Zwraca wartość parametru.
            }
        }
        return false; // Zwraca `false`, jeśli parametr nie został znaleziony lub nie ma wartości.
    }
}
