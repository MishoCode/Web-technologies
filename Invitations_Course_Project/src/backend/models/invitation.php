<?php

class InvitationModel
{
    private $id;
    private $title;
    private $place;
    private $date;
    private $time;
    private $endTime;

    private $presenter;
    private $filename;

    public function __construct(
        $id,
        $title,
        $place,
        $date,
        $time,
        $endTime,
        $presenter,
        $filename = ''
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->place = $place;
        $this->date = $date;
        $this->time = $time;
        $this->endTime = $endTime;
        $this->presenter = $presenter;
        $this->filename = $filename;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function getPresenter()
    {
        return $this->presenter;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }
}
?>