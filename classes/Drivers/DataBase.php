<?php

namespace Drivers;

class DataBase {

    // Prywatne właściwości klasy
    private $config;             // Konfiguracja połączenia z bazą danych
    private $sqlRowCount;        // Liczba zwróconych wierszy przez ostatnie zapytanie
    private $sqlErrorInfo;       // Informacje o błędzie ostatniego zapytania
    private $sqlErrorCode;       // Kod błędu ostatniego zapytania
    private $sqlLastInsertID;    // ID ostatnio wstawionego rekordu
    private $sqlData;            // Dane zwrócone przez ostatnie zapytanie

    // Konstruktor klasy, przyjmuje konfigurację połączenia
    public function __construct($config) {
        $this->config = $config;
    }

    // Metoda do nawiązywania połączenia z bazą danych
    public function dbConnect() {
        $this->config['handle'] = new \PDO(
            "mysql:dbname={$this->config['name']};host={$this->config['host']}",
            $this->config['user'],
            $this->config['pass'],
            array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'")
        );
    }

    // Metoda do wykonywania zapytań SELECT
    public function sqlSelect($sqlString, $sqlParameters = null) {
        $sql = $this->config['handle']->prepare($sqlString);
        $data = $sql->execute($sqlParameters);

        if ($data != false) {
            $this->sqlRowCount = $sql->rowCount(); // Liczba zwróconych wierszy
            $this->sqlData = $sql->fetchAll(\PDO::FETCH_ASSOC); // Pobranie danych w formacie asocjacyjnym
        } else {
            $this->sqlRowCount = 0; // Ustawienie liczby wierszy na 0 w przypadku błędu
            $this->sqlErrorInfo = $sql->errorInfo(); // Szczegóły błędu
            $this->sqlErrorCode = $sql->errorCode(); // Kod błędu
        }

        $sql->closeCursor(); // Zwolnienie zasobów zapytania
        return $data;
    }

    // Metoda do wstawiania danych do tabeli
    public function sqlInsert($table, $data) {
        $columns = implode(", ", array_keys($data)); // Nazwy kolumn
        $placeholders = ":" . implode(", :", array_keys($data)); // Placeholdery do wartości

        $sqlString = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $sql = $this->config['handle']->prepare($sqlString);

        $data = $sql->execute($data); // Wykonanie zapytania

        if ($data) {
            $this->sqlLastInsertID = $this->config['handle']->lastInsertId(); // Pobranie ID ostatnio wstawionego rekordu
        } else {
            $this->sqlErrorInfo = $sql->errorInfo(); // Szczegóły błędu
            $this->sqlErrorCode = $sql->errorCode(); // Kod błędu
        }

        return $data;
    }

    // Metoda do aktualizacji danych w tabeli
    public function sqlUpdate($table, $data, $conditions) {
        // Przygotowanie części SET dla zapytania
        $setClause = [];
        foreach ($data as $column => $value) {
            $setClause[] = "$column = :$column";
        }
        $setString = implode(", ", $setClause);

        // Przygotowanie części WHERE dla zapytania
        $whereClause = [];
        foreach ($conditions as $column => $value) {
            $whereClause[] = "$column = :cond_$column";
        }
        $whereString = implode(" AND ", $whereClause);

        // Tworzenie zapytania SQL
        $sqlString = "UPDATE $table SET $setString WHERE $whereString";

        // Przygotowanie i wykonanie zapytania
        $sql = $this->config['handle']->prepare($sqlString);

        // Łączenie parametrów danych i warunków
        $parameters = array_merge(
            $data,
            array_combine(
                array_map(fn($key) => "cond_$key", array_keys($conditions)),
                array_values($conditions)
            )
        );

        $result = $sql->execute($parameters); // Wykonanie zapytania

        if (!$result) {
            $this->sqlErrorInfo = $sql->errorInfo(); // Szczegóły błędu
            $this->sqlErrorCode = $sql->errorCode(); // Kod błędu
        }

        return $result;
    }

    // Metoda do usuwania danych z tabeli
    public function sqlDelete($table, $conditions) {
        // Przygotowanie części WHERE dla zapytania
        $whereClause = [];
        foreach ($conditions as $column => $value) {
            $whereClause[] = "$column = :cond_$column";
        }
        $whereString = implode(" AND ", $whereClause);

        // Tworzenie zapytania SQL
        $sqlString = "DELETE FROM $table WHERE $whereString";

        // Przygotowanie i wykonanie zapytania
        $sql = $this->config['handle']->prepare($sqlString);

        // Mapowanie parametrów
        $parameters = array_combine(
            array_map(fn($key) => "cond_$key", array_keys($conditions)),
            array_values($conditions)
        );

        $result = $sql->execute($parameters); // Wykonanie zapytania

        if (!$result) {
            $this->sqlErrorInfo = $sql->errorInfo(); // Szczegóły błędu
            $this->sqlErrorCode = $sql->errorCode(); // Kod błędu
        }

        return $result;
    }

    // Metoda zwracająca dane z ostatniego zapytania SELECT
    public function GetAllData() {
        return $this->sqlData;
    }
}
