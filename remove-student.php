<?php

require_once 'src/Domain/Model/student.php';
require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$prerparedStatement = $pdo->prepare('DELETE FROM students WHERE id = :id;');
$prerparedStatement->bindValue(':id', 1, PDO::PARAM_INT);   //O terceiro argumento é o TIPO do valor a ser passado

if( $prerparedStatement->execute()){
    echo "Aluno excluído";
}