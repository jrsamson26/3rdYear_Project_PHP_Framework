<?php
/**
 * Created by PhpStorm.
 * User: jr_sa
 * Date: 06/04/2016
 * Time: 11:01
 */
namespace Itb\Model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class User extends DatabaseTable
{
    //higher privillage access
    const ROLE_ADMIN = 2;

    //lower privillage access
    const ROLE_USER = 1;

    //meduim privillage access
    const ROLE_PROJECT_LEADER = 3;

    //supports the leader privillage access
    const ROLE_PROJECT_SECRETARY = 4;

    /**
     * varriables for id, username, password, and role
     * @var
     */
    private $id;
    private $username;
    private $password;
    private $role;


    /**
     * Setting the ID
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * getting the ID
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Setting the username
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


    /**
     * getting the username
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * hash the password before storing ...
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->password = $hashedPassword;
    }

    /**
     * return success (or not) of attempting to find matching username/password in the repo
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = User::getOneByUsername($username);

        // if no record has this username, return FALSE
        if(null == $user){
            return false;
        }

        // hashed correct password
        $hashedStoredPassword = $user->getPassword();

        // return whether or not hash of input password matches stored hash
        return password_verify($password, $hashedStoredPassword);
    }

    /**
     * looking for the user role 1 or 2 e.g. 2 = admin, 1 = users
     * @param $username
     * @return null
     */
    public static function canFindMatchingUsernameAndRole($username)
    {
        $user = User::getOneByUsername($username);

        if($user != null)
        {
            return $user -> getRole();
        }

        else
        {
            return null;
        }
    }

    /**
     * if record exists with $username, return User object for that record
     * otherwise return 'null'
     *
     * @param $username
     *
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }
}