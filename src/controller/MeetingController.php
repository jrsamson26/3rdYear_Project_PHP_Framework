<?php
/**
 * Created by PhpStorm.
 * User: jr_sa
 * Date: 29/04/2016
 * Time: 15:59
 */

namespace Itb\Controller;

use Itb\Model;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class MeetingController
{
    /**
     * displaying the students
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

    public function processAddMeeting(Request $request, Application $app)
    {
        $meetingId = filter_input(INPUT_POST, 'meetingId', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT);
        $approval = filter_input(INPUT_POST, 'approval', FILTER_SANITIZE_STRING);

        //if the meeting ID is not null
        if($meetingId != null)
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
                            $meeting->setMeetingId($meetingId);
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
        } //end if the meeting ID is not null
        else
        {
            $argsArray = [
                'message' => "Error - meeting ID has not filled in",// Error message output the page
                'message2' => 'Please trying again',
                'errorType' => 'add Meeting',// redirect to the pages
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }
}