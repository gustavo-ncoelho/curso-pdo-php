<?php 

require_once 'src/Domain/Model/student.php';
require_once 'src/Domain/Repository/StudentRepository.php';
require_once 'src/Infrastructure/Repository/PdoStudentRepository.php';
require_once 'src/Infrastructure/Persistance/ConnectionCreator.php';
require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();  // Aqui inicia-se uma transação, ou seja, operações ficam prontas para serem mandadas
                                  // para o banco de dados, porém só são enviadas depois do commit, igual no git.
try{
    $aStudent = new Student(null, 'Cabelera jones',new DateTimeImmutable('2020-09-30'));
    $studentRepository->save($aStudent);

    $connection->commit();
} catch(RuntimeException $e) {
    echo $e->getMessage();
    $connection->rollback();
}










