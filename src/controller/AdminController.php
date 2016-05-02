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
        $duplicateUsername = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
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


    /**
     * displaying the meetings
     * @return array
     */
    public function displayMeetings()
    {
        $meeting = Model\Meeting::getAll();

        return $meeting;
    }

    /**
     * Adding the meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addMeeting(Request $request, Application $app)
    {
        $meetings = $this->displayMeetings();
        $argsArray = [
            'meetings' => $meetings,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'addMeeting';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process Add Meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddMeeting(Request $request, Application $app)
    {

        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT);
        $approval = filter_input(INPUT_POST, 'approval', FILTER_SANITIZE_STRING);


            //if the description is not null
            if($description != null)
            {
                //if the time is not null
                if($time != null)
                {
                    //if the date is not null
                    if($date != null)
                    {
                        //if the approval is not null
                        if($approval != null)
                        {
                            $meeting = new Model\Meeting();
                            //$meeting->setMeetingId($id);
                            $meeting->setDescription($description);
                            $meeting->setTime($time);
                            $meeting->setDate($date);
                            $meeting->setApproval($approval);
                            Model\Meeting::insert($meeting);

                            $argsArray = [
                                'message' => "Meeting has been added to the database",// Success message
                                'nav' => $_SESSION['role'],
                                'successType' => "add Meeting"
                            ];
                            $templateName = 'process';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        }
                        else
                        {
                            $argsArray = [
                                'message' => "Error - approval has not filled in",// Error message output the page
                                'message2' => 'Please trying again',
                                'errorType' => 'add Meeting',// redirect to the pages
                                'nav' => $_SESSION["role"]
                            ];

                            $templateName = 'error';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        }
                    } //if the date is not null

                    else
                    {
                        $argsArray = [
                            'message' => "Error - date has not filled in",// Error message output the page
                            'message2' => 'Please trying again',
                            'errorType' => 'add Meeting',// redirect to the pages
                            'nav' => $_SESSION["role"]
                        ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                } //end if the time is not null

                else
                {
                    $argsArray = [
                        'message' => "Error - time has not filled in",// Error message output the page
                        'message2' => 'Please trying again',
                        'errorType' => 'add Meeting',// redirect to the pages
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } //end if the description is not null

            else
            {
                $argsArray = [
                    'message' => "Error - description has not filled in",// Error message output the page
                    'message2' => 'Please trying again',
                    'errorType' => 'add Meeting',// redirect to the pages
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }

    }

    /**
     * Remove the meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function removeMeeting(Request $request, Application $app)
    {
        $meetings = $this->displayMeetings();
        $argsArray = [
            'meetings' => $meetings,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'removeMeeting';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function processRemoveMeeting(Request $request, Application $app)
    {
        $meetingId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if($meetingId != null)
        {
            $isOnDatabase = Model\Meeting::getOneById($meetingId);

            if($isOnDatabase != null)
            {
                Model\Meeting::delete($meetingId);
                $argsArray = [
                    'message' => "Meeting has been removed form the database",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "remove Meeting"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }

            else
            {
                $argsArray = [
                    'message' => "Error - meeting ID must be a number",// Error message
                    'message2' => 'Please trying again',
                    'errorType' => 'remove Meeting',// Type of error used to give the right link back
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
                'errorType' => 'remove Meeting',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * update the meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function updateMeeting(Request $request, Application $app)
    {
        $meetings = $this->displayMeetings();
        $argsArray = [
            'meetings' => $meetings,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'updateMeeting';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process Add Meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processUpdateMeeting(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT);
        $approval = filter_input(INPUT_POST, 'approval', FILTER_SANITIZE_STRING);


        //if the meeting ID is not null
        if($id != null)
        {
        //if the description is not null
        if($description != null)
        {
            //if the time is not null
            if($time != null)
            {
                //if the date is not null
                if($date != null)
                {
                    //if the approval is not null
                    if($approval != null)
                    {
                        $meeting = new Model\Meeting();
                        $meeting->setId($id);
                        $meeting->setDescription($description);
                        $meeting->setTime($time);
                        $meeting->setDate($date);
                        $meeting->setApproval($approval);
                        Model\Meeting::update($meeting);

                        $argsArray = [
                            'message' => "Meeting has been added to the database",// Success message
                            'nav' => $_SESSION['role'],
                            'successType' => "update Meeting"
                        ];
                        $templateName = 'process';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                    else
                    {
                        $argsArray = [
                            'message' => "Error - approval has not filled in",// Error message output the page
                            'message2' => 'Please trying again',
                            'errorType' => 'update Meeting',// redirect to the pages
                            'nav' => $_SESSION["role"]
                        ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                } //if the date is not null

                else
                {
                    $argsArray = [
                        'message' => "Error - date has not filled in",// Error message output the page
                        'message2' => 'Please trying again',
                        'errorType' => 'update Meeting',// redirect to the pages
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } //end if the time is not null

            else
            {
                $argsArray = [
                    'message' => "Error - time has not filled in",// Error message output the page
                    'message2' => 'Please trying again',
                    'errorType' => 'update Meeting',// redirect to the pages
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } //end if the description is not null

        else
        {
            $argsArray = [
                'message' => "Error - description has not filled in",// Error message output the page
                'message2' => 'Please trying again',
                'errorType' => 'update Meeting',// redirect to the pages
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
        } //end if the meeting ID is not null

        else
        {
            $argsArray = [
                'message' => "Error - meeting ID has not filled in",// Error message output the page
                'message2' => 'Please trying again',
                'errorType' => 'update Meeting',// redirect to the pages
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }


    /**
     * displaying the projects
     * @return array
     */
    public function displayProjects()
    {
        $project = Model\Project::getAll();

        return $project;
    }

    /**
     * Adding the project
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addProject(Request $request, Application $app)
    {
        $projects = $this->displayProjects();
        $argsArray = [
            'projects' => $projects,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'addProject';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process Add project
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddProject(Request $request, Application $app)
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $member = filter_input(INPUT_POST, 'member', FILTER_SANITIZE_NUMBER_INT);
        $supervisor = filter_input(INPUT_POST, 'supervisor', FILTER_SANITIZE_NUMBER_INT);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);

        // if the title is not null
        if($title != null) {
            //if the description is not null
            if ($description != null) {
                //if the time is not null
                if ($member != null) {
                    //if the date is not null
                    if ($supervisor != null) {
                        //if the approval is not null
                        if ($deadline != null) {
                            $project = new Model\Project();
                            $project->setTitle($title);
                            $project->setDescription($description);
                            $project->setMembers($member);
                            $project->setSupervisor($supervisor);
                            $project->setDeadline($deadline);
                            Model\Project::insert($project);

                            $argsArray = [
                                'message' => "Project has been added to the database",// Success message
                                'nav' => $_SESSION['role'],
                                'successType' => "add Project"
                            ];
                            $templateName = 'process';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        } else {
                            $argsArray = [
                                'message' => "Error - deadline has not filled in",// Error message output the page
                                'message2' => 'Please trying again',
                                'errorType' => 'add Project',// redirect to the pages
                                'nav' => $_SESSION["role"]
                            ];

                            $templateName = 'error';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        }
                    } //if the date is not null

                    else {
                        $argsArray = [
                            'message' => "Error - supervisor has not filled in",// Error message output the page
                            'message2' => 'Please trying again',
                            'errorType' => 'add Project',// redirect to the pages
                            'nav' => $_SESSION["role"]
                        ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                } //end if the time is not null

                else {
                    $argsArray = [
                        'message' => "Error - member has not filled in",// Error message output the page
                        'message2' => 'Please trying again',
                        'errorType' => 'add Project',// redirect to the pages
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } //end if the description is not null

            else {
                $argsArray = [
                    'message' => "Error - description has not filled in",// Error message output the page
                    'message2' => 'Please trying again',
                    'errorType' => 'add Project',// redirect to the pages
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }

        else
        {
            $argsArray = [
                'message' => "Error - title has not filled in",// Error message output the page
                'message2' => 'Please trying again',
                'errorType' => 'add Project',// redirect to the pages
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

}//end of class