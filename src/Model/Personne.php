<?php


namespace App\Model;


class Personne
{
    public $name;
    public $firstname;
    public $age;

    /**
     * Personne constructor.
     * @param $name
     * @param $firstname
     * @param $age
     */
    public function __construct($name, $firstname, $age)
    {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

}