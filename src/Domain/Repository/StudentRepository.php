<?php

interface StudentRepository {

    public function allStudents(): array;
    public function studentsWithPhones(): array;
    public function studentsBirthAt(DateTimeImmutable $birtDahte) : array;
    public function save(Student $student) : bool;
    public function remove(Student $student) : bool;
}