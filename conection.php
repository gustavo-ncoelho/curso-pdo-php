<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

echo 'Conectei';

$createTableSql = '
    CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY,
        name TEXT,
        birthDate TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
        id INTEGER PRIMARY KEY,
        areaCode TEXT,
        number TEXT,
        studentId INTEGER,
        FOREIGN KEY (studentId) REFERENCES students(id)
    );   
';

$pdo->exec($createTableSql);