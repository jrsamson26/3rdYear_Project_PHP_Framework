<?php
/**
 * Created by PhpStorm.
 * User: jr_sa
 * Date: 02/05/2016
 * Time: 07:43
 */

namespace Itb\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class Project extends DatabaseTable
{
    /**
     * decleration of the id
     * @var
     */
    private $id;

    /**
     * title of the project
     * @var
     */
    private $title;

    /**
     * description of the project
     * @var
     */
    private $description;

    /**
     * members who is involved
     * @var
     */
    private $member;

    /**
     * supervisor who is looking forward to the project
     * @var
     */
    private $supervisor;

    /**
     * deadline of the projects
     * @var
     */
    private $deadline;

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
     * setting the title
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * getting the title
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * setting the description
     * @param $description#
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
     * setting the member whos is involved
     * @param $description#
     */
    public function setMembers($member)
    {
        $this->member = $member;
    }

    /**
     * getting the members
     * @return mixed
     */
    public function getMembers()
    {
        return $this->member;
    }

    /**
     * setting the supervisor who is supervising the project
     * @param $description#
     */
    public function setSupervisor($supervisor)
    {
        $this->supervisor = $supervisor;
    }

    /**
     * getting the supervisor who is supervising the project
     * @return mixed
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * setting the deadline of the project
     * @param $description#
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * getting the deadline of the project
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }
}