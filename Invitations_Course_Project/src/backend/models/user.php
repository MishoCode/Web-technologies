<?php

class UserModel
{
    private $fn;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $course;
    private $specialty;

    public function __construct(
        $fn,
        $email,
        $password,
        $firstName,
        $lastName,
        $course,
        $specialty
    )
    {
        $this->fn = $fn;
        $this->email = $email;
        $this->password = $password;
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

    public function getPassword()
    {
        return $this->password;
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