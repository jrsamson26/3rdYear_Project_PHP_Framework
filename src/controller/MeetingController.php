<?php
/**
 * Created by PhpStorm.
 * User: jr_sa
 * Date: 02/05/2016
 * Time: 13:48
 */

namespace Itb\Controller;

use Itb\Model\Meeting;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MeetingController
{
    /**
     * displaying the meetings
     * @return array
     */
    public function displayMeetings()
    {
        $meeting = Meeting::getAll();
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
        if (isset($_SESSION['role'])) {
        $meetings = $this->displayMeetings();
        $argsArray = [
            'meetings' => $meetings,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'addMeeting';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again',
            'errorType' => 'add Meeting' // Type of error used to give the right link back
        ];
        $templateName = 'error';
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
                        $meeting = new Meeting();
                        $meeting->setDescription($description);
                        $meeting->setTime($time);
                        $meeting->setDate($date);
                        $meeting->setApproval($approval);
                        Meeting::insert($meeting);

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
            $isOnDatabase = Meeting::getOneById($meetingId);

            if($isOnDatabase != null)
            {
                Meeting::delete($meetingId);
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
                            $meeting = new Meeting();
                            $meeting->setId($id);
                            $meeting->setDescription($description);
                            $meeting->setTime($time);
                            $meeting->setDate($date);
                            $meeting->setApproval($approval);
                            Meeting::update($meeting);

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

    public function listMeetings(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            $meetings = Meeting::getAll();

            $argsArray = [
                'meetings' => $meetings,
                'nav' => $_SESSION["role"]
            ];
            $templateName = 'listMeeting';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);

        }
        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again :)',
            'errorType' => '',// Type of error used to give the right link back
        ];
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}