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
}
