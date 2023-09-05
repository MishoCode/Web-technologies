<?php

class LikeDto
{
    public $user;

    public $invitation;

    public function __construct($user, $invitation)
    {
        $this->user = $user;
        $this->invitation = $invitation;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getInvitation()
    {
        return $this->invitation;
    }
}

?>