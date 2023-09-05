<?php

require_once '../repositories/invitation-repository.php';
require_once '../mappers/invitation-mapper.php';

class InvitationService
{
    private $invitationRepository;

    public function __construct()
    {
        $this->invitationRepository = new InvitationRepository();
    }

    public function createInvitation($title, $place, $date, $time, $endTime, $presenter_fn, $filename)
    {
        $invitation = $this->invitationRepository->findInvitationByTitle($title);
        if ($invitation && $invitation["presenter_fn"] !== $_SESSION["fn"]) {
            throw new InvalidArgumentException("Invitation with this title already exists");
        }

        if ($this->invitationRepository->findInvitationByPresenter($presenter_fn)) {
            $this->invitationRepository->deleteInvitationByPresenter($presenter_fn);
        }

        if ($this->invitationRepository->findInvitationByDateAndTime($date, $time)) {
            throw new InvalidArgumentException("This time slot is already taken. Choose another one.");
        }

        $result = $this->invitationRepository->createInvitation($title, $place, $date, $time, $endTime, $presenter_fn, $filename);

        return $result;
    }

    public function getAllInvitations()
    {
        $invitations = $this->invitationRepository->getAllInvitations();
        return $this->listInvitations($invitations);
    }

    public function getUpcomingInvitations()
    {
        $invitations = $this->invitationRepository->getUpcomingInvitations();
        return $this->listInvitations($invitations);
    }

    public function listInvitations($invitations)
    {
        foreach ($invitations as $i) {
            $filename = $i->getFilename();
            if ($filename !== null && $filename !== 'NULL') {
                $encodedName = base64_encode(file_get_contents('../upload/' . $i->getFilename()));
                $i->setFilename($encodedName);
            } else if ($filename === null) {
                $i->setFilename('NULL');
            }
        }

        return array_map(array('InvitationMapper', 'toDto'), $invitations);
    }
}

?>