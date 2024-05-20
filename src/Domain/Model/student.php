<?php


class Student {
    private ?int $id;
    private string $name;
    private DateTimeImmutable $birthDate;
    private array $phones = [];

    public function __construct(?int $id, string $name, DateTimeImmutable $birthDate) {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function defineId(int $id): void {
        if(!is_null($this->id)){
            throw new \DomainException("Você só pode definir o ID uma vez");
        }
        
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $newName) {
        $this->name = $newName;
    }

    public function getBirthDate(): DateTimeImmutable {
        return $this->birthDate;
    }

    public function age(): int {
        return $this->birthDate->diff(new \DateTimeImmutable())->y;
    }

    public function addPhone(Phone $phone): void {
        $this->phones[] = $phone;
    }

    public function getPhones(): array {
        return $this->phones;
    }
}