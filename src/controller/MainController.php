<?php

namespace Itb\Controller;

use Itb\Model;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{
    /**
     * passing the twig
     * @param $twig
     */
    public function indexAction(Request $request, Application $app)
    {
        $argsArray = [];

        $templateName = 'index';
       return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * processing the loggin page
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processLogInAction(Request $request, Application $app)
    {
        // default is bad login
        $LoggedIn = false;

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        //reference for User Class
        $user = new Model\User();
        //searching for the username and password if they have match
        $LoggedIn = $user->canFindMatchingUsernameAndPassword($username, $password);


        //searching if the role is exist
        $isRole = $user->canFindMatchingUsernameAndRole($username);

        // action depending on login success
        if ($LoggedIn)
        {
            //session start when they logged in
            $_SESSION['username'] = $username;
            $_SESSION['LoggedIn']= $LoggedIn;
            $_SESSION['role']= $isRole;
            $_SESSION['hasLoggedIn'] = "yes";

            // finding the username and password if they have match
            $argsArray = [
                'username' => $username,
                'nav' => $_SESSION['role']
            ];

            $templateName = 'login';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        //if the username and password are wrong
        else
        {
            $argsArray = [
                'message' => 'Error - Username or Password is wrong',
                'message2' => 'Please Try again',
                'errorType' => 'login' //redirect to the log in page
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * List of all of the students
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function listStudent(Request $request, Application $app)
    {
        $students = Model\User::getAll();

        $argsArray = [
            'students' => $students,
            'nav' => $_SESSION['role']
        ];

        $templateName = 'listStudents';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * list the meetings
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function listMeeting(Request $request, Application $app)
    {
        $meetings = Model\Meeting::getAll();

        $argsArray = [
            'meetings' => $meetings,
            'nav' => $_SESSION['role']
        ];

        $templateName = 'listMeeting';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


    /**
     * list the meetings
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function listProject(Request $request, Application $app)
    {
        $projects = Model\Project::getAll();

        $argsArray = [
            'projects' => $projects,
            'nav' => $_SESSION['role']
        ];

        $templateName = 'listProjects';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Killing the session of the php
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function killSession(Request $request, Application $app)
    {
        $_SESSION = [];
        session_destroy();

        $argsArray = [
            'logout' => "You have been logout"
        ];

        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * registering the students
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function registerStudents(Request $request, Application $app)
    {
        $argsArray = [];
        //calling the register files
        $templateName = 'register';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }

    /**
     * processing the registering the students with have no duplicate username
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRegisterStudent(Request $request, Application $app)
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'retypePassword', FILTER_SANITIZE_STRING);
        //prompt for user to be 1 so cannot access the admin controller
        $role = Model\User::ROLE_USER;

        //if the user is empty
        if ($username != null)
        {
            //if the password is equal to password confirmation
            if ($password == $confirmPassword)
            {
                //if the username is not in the database
                $isNotInDatabase = Model\User::getOneByUsername($username);

                if ($isNotInDatabase != true)
                {
                    $student = new Model\User();
                    $student->setUsername($username);
                    $student->setPassword($password);
                    $student->setRole($role);
                    Model\User::insert($student);

                    $_SESSION['role'] = $role;

                    $argsArray = [
                        'username' => $username,
                        'message' => "The Role is set to the database user = 1.",
                        'message2' => "Please contact an admin to change your role",
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'process';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }

                else
                {
                    $argsArray = [
                        'message' => "Error - Username is taken",// Error message
                        'message2' => 'Please trying again',
                        'errorType' => 'register Student'// Type of error used to give the right link back
                    ];
                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            }
            else
            {
                $argsArray = [
                    'message' => "Error - Passwords don't match!",// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'register Student'// Type of error used to give the right link back
                ];
                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
        else
        {
            $argsArray = [
                'message' => "Error - Username not filled in!",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'register Student'// Type of error used to give the right link back
            ];
            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }
}
