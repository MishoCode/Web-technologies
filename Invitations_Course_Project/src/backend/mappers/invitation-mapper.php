<?php

require_once '../models/invitation.php';
require_once '../models/user.php';
require_once '../mappers/user-mapper.php';
require_once '../dto/invitation-dto.php';

class InvitationMapper
{
    public static function toModel($data)
    {
        return new InvitationModel(
            $data["id"],
            $data["title"],
            $data["place"],
            $data["date"],
            $data["time"],
            $data["end_time"],
            new UserModel($data["presenter_fn"], $data["email"], $data["password"], $data["first_name"], $data["last_name"], $data["course"], $data["specialty"]),
            $data["filename"]
        );
    }

    public static function toDto($invitation)
    {
        return new InvitationDto(
            $invitation->getId(),
            $invitation->getTitle(),
            $invitation->getPlace(),
            $invitation->getDate(),
            $invitation->getTime(),
            $invitation->getEndTime(),
            UserMapper::toDto($invitation->getPresenter()),
            $invitation->getFilename()
        );
    }

    public static function toPlainDto($invitation)
    {
        return new InvitationDto(
            $invitation->getId(),
            $invitation->getTitle(),
            $invitation->getPlace(),
            $invitation->getDate(),
            $invitation->getTime(),
            $invitation->getEndTime(),
            $invitation->getPresenter(),
            $invitation->getFilename()
        );
    }
}

?>