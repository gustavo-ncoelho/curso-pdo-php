<?php

require_once 'src/Domain/Repository/StudentRepository.php';
require_once 'src/Domain/Model/student.php';
require_once 'src/Infrastructure/Persistance/ConnectionCreator.php';
require_once 'src/Infrastructure/Repository/PdoStudentRepository.php';
require_once 'src/Domain/Model/Phone.php';

$pdo = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudents();  


var_dump($studentList);