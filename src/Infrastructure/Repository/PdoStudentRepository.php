<?php

class PdoStudentRepository implements StudentRepository {

    private PDO $connection;

    public function __construct(PDO $connection){
        $this->connection = $connection;
    }

    public function hydrateStudentList(\PDOStatement $stmt): array{
        $studentDataList = $stmt->fetchAll(); // não é necessário fetch_assoc pois foi settado como padrão na implementação deste PDO
        $studentList = [];

        foreach ($studentDataList as $studentData){ 
           $studentList[] = new Student(                     //OBS: O FETCH CLASS FAZ EXATAMENTO ISSO <-
                $studentData['id'],                           //CRIA UMA LISTA DE OBJETOS STUDENT
                $studentData['name'],
                new DateTimeImmutable($studentData['birthDate'])
            );
        }
        return $studentList;
    }

    public function allStudents(): array {
        $statement = $this->connection->query('SELECT * FROM students');
        return $this->hydrateStudentList($statement);
    }
    public function studentsBirthAt(DateTimeImmutable $birthDate): array {
        $sqlQuery = 'SELECT * FROM students WHERE birthDate = :birthDate';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(':birthDate',$birthDate->format('Y-m-d H'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    public function update(Student $student): bool {
        $updateQuery = 'UPDATE students SET name = :name, birthDate = :birthDate WHERE id = :id';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(':name', $student->getName());
        $stmt->bindValue(':birthDate',$student->getBirthDate()->format('Y-m-d'));
        $stmt->bindValue(':id',$student->getId(), PDO::PARAM_INT); //SEMPRE QUE O PARÂMETRO FOR IN DEVE-SE ESPECIFICAR O TIPO
        $success = $stmt->execute();
        if($success){
            echo "Aluno atualizado!";
        }
        return $success;
    }
    public function save(Student $student): bool {

        $sqlInsert = "INSERT INTO students (name, birthDate) VALUES (:name , :birthDate)";
        $statement = $this->connection->prepare($sqlInsert);
        if ($statement === false){
            throw new RuntimeException($this->connection->errorInfo()[2]);
        }

        $statement->bindValue(':name' , $student->getName());
        $statement->bindValue(':birthDate', $student->getBirthDate()->format('Y-m-d'));
        $success = $statement->execute();
        if ($success){
            $student->defineId($this->connection->lastInsertId());
            echo "Aluno incluído";
        }
        return $success;
    }
    public function remove(Student $student): bool {

        $prerparedStatement = $this->connection->prepare('DELETE FROM students WHERE id = :id;');
        $prerparedStatement->bindValue(':id', 1, PDO::PARAM_INT);   //O terceiro argumento é o TIPO do valor a ser passado
        $success = $prerparedStatement->execute();
        if($success){
            echo "Aluno excluído";
        }
        return $success;
    }

    public function studentsWithPhones(): array {
        $sqlQuery = "SELECT students.id, 
                            students.name, 
                            students.birthDate,
                            phones.id AS phoneId,
                            phones.areaCode,
                            phones.number
                       FROM students
                       JOIN phones ON students.id = phones.studentId;";
        $statement = $this->connection->prepare($sqlQuery);
        $result = $statement->fetchAll();
        $studentList = [];
        
        foreach($result as $row){
            if (!array_key_exists($row["id"], $studentList)){
                $studentList[$row["id"]] = new Student($row['id'], $row['name'], new DateTimeImmutable($row['birthDate']));
            }
            $phone = new Phone($row['phoneId'], $row['areaCode'], $row['number']);
            $studentList[$row['id']]->addPhone($phone);
            
        }

        return $studentList;
    }
}