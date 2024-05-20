<?php

require_once 'src/Domain/Model/student.php';
require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$student = new Student(null, 'José da silvia',new DateTimeImmutable('2023-07-25'));

$sqlInsert = "INSERT INTO students (name, birthDate) VALUES (:name , :birthDate)";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(':name' , $student->getName());
$statement->bindValue(':birthDate', $student->getBirthDate()->format('Y-m-d'));
if ($statement->execute()){
    echo "Aluno incluído";
}
