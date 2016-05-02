<?php

namespace Itb\Controller;

use Itb\Model;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AdminController
{
    /**
     * displaying all students in the system
     * @return array
     */
    public function displayStudents()
    {
        $student = Model\User::getAll();

        return $student;
    }

    /**
     * adding the students
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addStudent(Request $request, Application $app)
    {
        $students = $this->displayStudents();
        $argsArray = [
            'students' => $students,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'addStudent';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }

    /**
     * processing the add students and duplicate users and password is not the same
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddStudent(Request $request, Application $app)
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'retypePassword', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        //if the username is null
        if ($username != null)
        {
            //if the password match

            if ($password == $confirmPassword)
            {
                //if the username is not in the database
                $isNotInDatabase = Model\User::getOneByUsername($username);

                if ($isNotInDatabase != true)
                {
                    $student = new Model\User();
                    $student->setPassword($password);
                    $student->setUsername($username);
                    $student->setRole($role);
                    Model\User::insert($student);

                    $argsArray = [
                        'message' => "Student has been added to the database",// Success message
                        'message2' => "Student is duplicated",
                        'nav' => $_SESSION['role'],
                        'successType' => "add Student"
                    ];
                    $templateName = 'process';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
                else
                {
                    $argsArray = [
                        'message' => "Error - Username is taken",// Error message
                        'message2' => 'Please trying again',
                        'errorType' => 'add Student'// Type of error used to give the right link back
                    ];
                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }


            }//end of if statement
            else
            {
                $argsArray = [
                    'message' => "Error - Passwords did not mach",// Error message
                    'message2' => 'Please trying again',
                    'errorType' => 'add Student',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
        else
        {
            $argsArray = [
                'message' => "Error - username has no filled in",// Error message output the page
                'message2' => 'Please trying again',
                'errorType' => 'add Student',// redirect to the pages
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * going to the form and remove student by username and id
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function removeStudent(Request $request, Application $app)
    {
        $students  = $this->displayStudents();

        $argsArray = [
          'students' => $students,
          'nav' => $_SESSION['role']
        ];

        $templateName = 'removeStudent';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * processing to remove students by username and id
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRemoveStudent(Request $request, Application $app)
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if($username!= null && $id != null)
        {
            $isOnDatabase1 = Model\User::getOneByUsername($username);
            $isOnDatabase2 = Model\User::getOneById($id);

            if($isOnDatabase1 != null && $isOnDatabase2 != null)
            {
                $student = new Model\User();
                $student->setUsername($username);
                $student->setId($id);
                Model\User::delete($username);
                Model\User::delete($id);

                $argsArray = [
                    'message' => "User has been removed form the database",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "delete Student"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
            else {
                $argsArray = [
                    'message' => "Error - There was no user with Id : ".$username, $id,// Error message
                    'message2' => 'Please trying again',
                    'errorType' => 'removeUser',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
        else
        {
            $argsArray = [
                'message' => "Error - username or id not filled in",// Error message
                'message2' => 'Please trying again',
                'errorType' => 'removeUser',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * going to update student
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function updateStudent(Request $request, Application $app)
    {
        $students  = $this->displayStudents();

        $argsArray = [
            'students' => $students,
            'nav' => $_SESSION['role']
        ];

        $templateName = 'updateStudent';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function processUpdateStudent(Request $request, Application $app)
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'retypePassword', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        if($id != null) {
            //if the user is correct
            if ($password == $confirmPassword) {
                //if the username is not null
                if ($username != null) {
                    //if the user has found 1, 2, 3, 4 change the role
                    if ($role == 1 || $role == 2) {
                        $student = new Model\User();
                        $student->setId($id);
                        $student->setUsername($username);
                        $student->setPassword($password);
                        $student->setRole($role);

                        Model\User::update($student);

                        $argsArray = [
                            'message' => "User has been updated in the system.",
                            'nav' => $_SESSION['role'],
                            'successType' => "update Student"
                        ];

                        $templateName = 'process';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }

                    else {
                        $argsArray = [
                            'message' => "Error - Role must be a number",// Error message
                            'message2' => 'Please trying again',
                            'errorType' => 'update student',// Type of error used to give the right link back
                            'nav' => $_SESSION["role"]
                        ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);

                    }
                } else {
                    $argsArray = [
                        'message' => "Error - Username not filled in",// Error message
                        'message2' => 'Please trying again',
                        'errorType' => 'update student',// Type of error used to give the right link back
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }


            } else {
                $argsArray = [
                    'message' => "Error - Passwords don't match",// Error message
                    'message2' => 'Please trying again',
                    'errorType' => 'update student',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
        else {
            $argsArray = [
                'message' => "Error - Id not filled in",// Error message
                'message2' => 'Please trying again',
                'errorType' => 'updateUser',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

}//end of class