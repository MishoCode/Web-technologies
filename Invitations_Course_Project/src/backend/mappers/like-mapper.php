<?php

require_once '../models/user.php';
require_once '../models/like.php';
require_once '../mappers/user-mapper.php';
require_once '../mappers/invitation-mapper.php';
require_once '../dto/like-dto.php';


class LikeMapper
{

    public static function toModel($data)
    {
        return new LikeModel(
            new UserModel($data["fn"], $data["email"], $data["password"], $data["first_name"], $data["last_name"], $data["course"], $data["specialty"]),
            new InvitationModel($data["id"], $data["title"], $data["place"], $data["date"], $data["time"], $data["end_time"], $data["presenter_fn"], $data["filename"])
        );
    }

    public static function toDto($like)
    {
        return new LikeDto(
            UserMapper::toDto($like->getUser()),
            InvitationMapper::toPlainDto($like->getInvitation())
        );
    }
}

?>