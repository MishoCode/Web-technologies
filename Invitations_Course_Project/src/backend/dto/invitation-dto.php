<?php

class InvitationDto
{
    public $id;
    public $title;
    public $place;

    public $date;

    public $time;

    public $endTime;

    public $filename;

    public $presenter;

    public function __construct(
        $id,
        $title,
        $place,
        $date,
        $time,
        $endTime,
        $presenter,
        $filename
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

    public function getTitle()
    {
        return $this->title;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function getPresener()
    {
        return $this->presenter;
    }

    public function getFilename()
    {
        return $this->filename;
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