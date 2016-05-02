<?php
// load classes
// ---------------------------------------
require_once __DIR__ . '/../loader/mainLoader.php';
require_once __DIR__ . '/../loader/db.php';

session_start();
//main view
$app->get('/', 'Itb\Controller\MainController::indexAction');
//logging processing the log in actions
$app->post('/login', 'Itb\Controller\MainController::processLogInAction');

//log out killing the session
$app->get('/killSession', 'Itb\Controller\MainController::killSession');

//view the list
$app->get('/listStudents', 'Itb\Controller\MainController::listStudent');
$app->get('/listMeeting', 'Itb\Controller\MainController::listMeeting');
$app->get('/listProjects', 'Itb\Controller\MainController::listProject');

//register for all students/users
$app->get('/register', 'Itb\Controller\MainController::registerStudents');
$app->post('/processRegisterStudent', 'Itb\Controller\MainController::processRegisterStudent');

//admin adding Student
//take note get and post must be together
$app->get('/addStudent', 'Itb\Controller\AdminController::addStudent');
$app->post('/processAddStudent', 'Itb\Controller\AdminController::processAddStudent');

//admin delete students
$app->get('/removeStudent', 'Itb\Controller\AdminController::removeStudent');
$app->post('/processRemoveStudent', 'Itb\Controller\AdminController::processRemoveStudent');

//admin update students
$app->get('/updateStudent', 'Itb\Controller\AdminController::updateStudent');
$app->post('/processUpdateStudent', 'Itb\Controller\AdminController::processUpdateStudent');


//admin adding Meeting
//take note get and post must be together
$app->get('/addMeeting', 'Itb\Controller\MeetingController::addMeeting');
$app->post('/processAddMeeting', 'Itb\Controller\MeetingController::processAddMeeting');

//admin delete meeting
$app->get('/removeMeeting', 'Itb\Controller\MeetingController::removeMeeting');
$app->post('/processRemoveMeeting', 'Itb\Controller\MeetingController::processRemoveMeeting');

//admin update meeting
$app->get('/updateMeeting', 'Itb\Controller\MeetingController::updateMeeting');
$app->post('/processUpdateMeeting', 'Itb\Controller\MeetingController::processUpdateMeeting');

//getting the display minutes of the agenda meetings
$app->get('/minutes', 'Itb\Controller\MeetingController::listProject');


//I tried to implement the project but it didn't work
// Admin add project
$app->get('/addProject', 'Itb\Controller\ProjectController::addProject');
$app->post('/processAddProject', 'Itb\Controller\ProjectController::processAddProject');

$app->get('/removeProject', 'Itb\Controller\ProjectController::removeProject');
$app->post('/processRemoveProject', 'Itb\Controller\ProjectController::processRemoveProject');

$app->get('/updateProject', 'Itb\Controller\ProjectController::updateProject');
$app->post('/processUpdateProject', 'Itb\Controller\ProjectController::processUpdateProject');
//end of project debugging



//$app['debug'] = true;
$app->error(function (\Exception $e, $code) use ($app) {
    $errorController = new Itb\Controller\ErrorController();
    return $errorController->errorAction($app, $code);
});


$app->run();
