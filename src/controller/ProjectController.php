<?php

namespace Itb\Controller;

use Itb\Model\Project;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ProjectController
{
    /**
     * display the porjects
     * @return array
     */
    public function displayProjects()
    {
        $project = Project::getAll();

        return $project;
    }

    /**
     * adding the project to the database and calling the form
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addProject(Request $request, Application $app)
    {
        if(isset($_SESSION['role'])) {
            $projects = $this->displayProjects();
            $argsArray = [
                'projects' => $projects,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'addProject';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again',
            'errorType' => 'add Project' // Type of error used to give the right link back
        ];
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process Add Project in the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddProject(Request $request, Application $app)
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $member = filter_input(INPUT_POST, 'member', FILTER_SANITIZE_STRING);
        $supervisor = filter_input(INPUT_POST, 'supervisor', FILTER_SANITIZE_STRING);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
        //if the description is not null
        if($title != null && $description != null && $member != null && $supervisor != null && $deadline != null) {
            //setting the data in the project table
            $project = new Project();
            $project->setTitle($title);
            $project->setDescription($description);
            $project->setMember($member);
            $project->setSupervisor($supervisor);
            $project->setDeadline($deadline);
            Project::insert($project);

            $argsArray = [
                'message' => "Project has been added to the database",// Success message
                'nav' => $_SESSION['role'],
                'successType' => "add Project"
            ];
            $templateName = 'process';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
        else
        {
            $argsArray = [
                'message' => "Error - No data has been input",// Error message
                'message2' => 'Please trying again',
                'errorType' => 'add Project' // Type of error used to give the right link back
            ];
            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * deleting the project to the database and calling the form
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function removeProject(Request $request, Application $app)
    {
        if(isset($_SESSION['role'])) {
            $projects = $this->displayProjects();
            $argsArray = [
                'projects' => $projects,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'removeProject';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again',
            'errorType' => 'remove Project' // Type of error used to give the right link back
        ];
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process Add Project in the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRemoveProject(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if($id != null) {
            $isOnDatabase = Project::getOneById($id);

            if($isOnDatabase != null) {
                //setting the data in the project table
                Project::delete($id);

                $argsArray = [
                    'message' => "Project has been deleted to the database",// Success message
                    'nav' => $_SESSION['role'],
                    'successType' => "remove Project"
                ];
                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }

            else
            {
                $argsArray = [
                    'message' => "Error - meeting ID must be a number",// Error message
                    'message2' => 'Please trying again',
                    'errorType' => 'remove Project',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }

        else
        {
            $argsArray = [
                'message' => "Error - Cannot find the ID",// Error message
                'message2' => 'Please trying again',
                'errorType' => 'add Project' // Type of error used to give the right link back
            ];
            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }


    /**
     * update the project
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function updateProject(Request $request, Application $app)
    {
        if(isset($_SESSION['role'])) {
            $projects = $this->displayProjects();
            $argsArray = [
                'projects' => $projects,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'updateProject';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }

        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again',
            'errorType' => 'update Project' // Type of error used to give the right link back
        ];
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * process Add Project in the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processUpdateProject(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $member = filter_input(INPUT_POST, 'member', FILTER_SANITIZE_STRING);
        $supervisor = filter_input(INPUT_POST, 'supervisor', FILTER_SANITIZE_STRING);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
        //if the description is not null
        if($id != null && $title != null && $description != null && $member != null && $supervisor != null && $deadline != null) {
            //setting the data in the project table
            $project = new Project();
            $project->setId($id);
            $project->setTitle($title);
            $project->setDescription($description);
            $project->setMember($member);
            $project->setSupervisor($supervisor);
            $project->setDeadline($deadline);
            Project::update($project);

            $argsArray = [
                'message' => "Project has been update to the database",// Success message
                'nav' => $_SESSION['role'],
                'successType' => "update Project"
            ];
            $templateName = 'process';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
        else
        {
            $argsArray = [
                'message' => "Error - No data has been input",// Error message
                'message2' => 'Please trying again',
                'errorType' => 'update Project' // Type of error used to give the right link back
            ];
            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }
}
