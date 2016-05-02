<?php

namespace Itb\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;

class FutureMeeting extends DatabaseTable
{
    /**
     * decleration for future meetings Id, description, day, time, duration room
     * @var
     */
    private $id;
    private $description;
    private $day;
    private $time;
    private $duration;
    private $room;

    /**
     * setting the id
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * getting the id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * setting the description
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * getting the description
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * setting the day
     * @param $description
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * getting the day
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * setting the Time
     * @param $description
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * getting the Time
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * setting the duration
     * @param $description
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * getting the duration
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * setting the room
     * @param $description
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * getting the room
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }
}