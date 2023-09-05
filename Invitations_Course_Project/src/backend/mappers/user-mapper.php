<?php

require_once '../models/user.php';
require_once '../dto/user-dto.php';

class UserMapper
{
    public static function toModel($data)
    {
        return new UserModel(
            $data['fn'],
            $data['email'],
            $data['password'],
            $data['first_name'],
            $data['last_name'],
            $data['course'],
            $data['specialty']
        );
    }

    public static function toDto($user)
    {
        return new UserDto(
            $user->getFn(),
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getCourse(),
            $user->getSpecialty()
        );
    }
}

?>