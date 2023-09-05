<?php

class UserDto
{
    public $fn;
    public $email;
    public $firstName;
    public $lastName;
    public $course;
    public $specialty;

    public function __construct(
        $fn,
        $email,
        $firstName,
        $lastName,
        $course,
        $specialty
    )
    {
        $this->fn = $fn;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->course = $course;
        $this->specialty = $specialty;
    }

    public function getFn()
    {
        return $this->fn;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function getSpecialty()
    {
        return $this->specialty;
    }
}

?>