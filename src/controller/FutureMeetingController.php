<?php
/**
 * Created by PhpStorm.
 * User: jr_sa
 * Date: 02/05/2016
 * Time: 13:48
 */

namespace Itb\Controller;

use Itb\Model\FutureMeeting;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class FutureMeetingController
{
    /**
     * displaying the meetings
     * @return array
     */
    public function displayFutureMeetings()
    {
        $futuremeeting = FutureMeeting::getAll();
        return $futuremeeting;
    }

    /**
     * Adding the meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addFutureMeeting(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {

            $futuremeetings = $this->displayFutureMeetings();

            $argsArray = [
                'futuremeetings' => $futuremeetings,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'addFutureMeeting';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again',
            'errorType' => 'add Future Meeting' // Type of error used to give the right link back
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
    public function processAddFutureMeeting(Request $request, Application $app)
    {
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $day = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT);
        $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_NUMBER_INT);
        $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_STRING);



        $futuremeeting = new FutureMeeting();
        $futuremeeting->setDescription($description);
        $futuremeeting->setDay($day);
        $futuremeeting->setTime($time);
        $futuremeeting->setDuration($duration);
        $futuremeeting->setRoom($room);
        FutureMeeting::insert($futuremeeting);

        $argsArray = [
            'message' => "Meeting has been added to the database",// Success message
            'nav' => $_SESSION['role'],
            'successType' => "add Future Meeting"
        ];

        $templateName = 'process';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);


    }

    /**
     * Remove the meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function removeFutureMeeting(Request $request, Application $app)
    {
        $futuremeetings = $this->displayFutureMeetings();
        $argsArray = [
            'futuremeetings' => $futuremeetings,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'removeFutureMeeting';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function processRemoveFutureMeeting(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if($id != null)
        {
            $isOnDatabase = FutureMeeting::getOneById($id);

            if($isOnDatabase != null)
            {
                FutureMeeting::delete($id);
                $argsArray = [
                    'message' => "Future Meeting has been removed form the database",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "remove Future Meeting"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }

            else
            {
                $argsArray = [
                    'message' => "Error - meeting ID must be a number",// Error message
                    'message2' => 'Please trying again',
                    'errorType' => 'remove Future Meeting',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }

        }

        else
        {
            $argsArray = [
                'message' => "Error - id not filled in",// Error message
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
    public function updateFutureMeeting(Request $request, Application $app)
    {
        $futuremeetings = $this->displayFutureMeetings();
        $argsArray = [
            'futuremeetings' => $futuremeetings,
            'nav' => $_SESSION["role"]
        ];

        $templateName = 'updateFutureMeeting';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process Add Meeting
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processUpdateFutureMeeting(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $day = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT);
        $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_NUMBER_INT);
        $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_STRING);


        $futuremeeting = new FutureMeeting();
        $futuremeeting->setId($id);
        $futuremeeting->setDescription($description);
        $futuremeeting->setDay($day);
        $futuremeeting->setTime($time);
        $futuremeeting->setDuration($duration);
        $futuremeeting->setRoom($room);
        FutureMeeting::update($futuremeeting);

        $argsArray = [
            'message' => "Meeting has been added to the database",// Success message
            'nav' => $_SESSION['role'],
            'successType' => "update Meeting"
        ];
        $templateName = 'process';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
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