<?php

require_once '../repositories/like-repository.php';
require_once '../mappers/like-mapper.php';

class LikeService
{
    private $likeRepository;

    public function __construct()
    {
        $this->likeRepository = new LikeRepository();
    }

    public function createLike($fn, $invitation_id)
    {
        if ($this->likeRepository->findLike($fn, $invitation_id)) {
            throw new InvalidArgumentException("This like already exists");
        }

        return $this->likeRepository->createLike($fn, $invitation_id);
    }

    public function getAllLikes()
    {
        $likes = $this->likeRepository->getAllLikes();
        return array_map(array('LikeMapper', 'toDto'), $likes);
    }
}

?>