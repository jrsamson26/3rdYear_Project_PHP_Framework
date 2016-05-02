<?php

namespace Itb\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;

class Meeting extends DatabaseTable
{
    /**
     * decleration for meetingId, description, date, time, approval
     * @var
     */
    private $id;
    private $description;
    private $date;
    private $time;
    private $room;
    private $approval;

    /**
     * setting the meeting ID
     * @param $meetingId
     */
    public function setId($id)
    {
        $this -> id = $id;
    }

    /**
     * getting the meeting id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * setting the description of the meeting
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * getting the description of the meeting
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * setting the date for the meeting
     * @param $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * getting the date for the meeting
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * setting the time of the meetings
     * @param $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * getting the time of the meetings
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * setting the time of the meetings
     * @param $time
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * getting the time of the meetings
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * setting the approval to yes, no, maybe
     * @param $approval
     */
    public function setApproval($approval)
    {
        $this->approval = $approval;
    }

    /**
     * getting the approval to yes, no, maybe
     * @return mixed
     */
    public function getApproval()
    {
        return $this->approval;
    }

    /*
    public static function getApprovalToYes($approval)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM meetings';
        $statement = $connection->prepare($sql);
        $statement->bindParam()
    }
    */
}