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

//view the list
$app->get('/listStudents', 'Itb\Controller\MainController::listStudent');
$app->get('/listMeeting', 'Itb\Controller\MainController::listMeeting');

//log out killing the session
$app->get('/killSession', 'Itb\Controller\MainController::killSession');

//register for all students/users
$app->get('/register', 'Itb\Controller\MainController::registerStudents');
$app->post('/processRegisterStudent', 'Itb\Controller\MainController::processRegisterStudent');

//admin adding Student
//take note get and post must be together
$app->get('/addStudent', 'Itb\Controller\AdminController::addStudent');
$app->post('/processAddStudent', 'Itb\Controller\AdminController::processAddStudent');


//delete students
$app->get('/removeStudent', 'Itb\Controller\AdminController::removeStudent');
$app->post('/processRemoveStudent', 'Itb\Controller\AdminController::processRemoveStudent');

// update students
$app->get('/updateStudent', 'Itb\Controller\AdminController::updateStudent');
$app->post('/processUpdateStudent', 'Itb\Controller\AdminController::processUpdateStudent');


//admin adding Meeting
//take note get and post must be together
$app->get('/addMeeting', 'Itb\Controller\AdminController::addMeeting');
$app->post('/processAddMeeting', 'Itb\Controller\AdminController::processAddMeeting');

//delete meeting
$app->get('/removeMeeting', 'Itb\Controller\AdminController::removeMeeting');
$app->post('/processRemoveMeeting', 'Itb\Controller\AdminController::processRemoveMeeting');

//update meeting
$app->get('/updateMeeting', 'Itb\Controller\AdminController::updateMeeting');
$app->post('/processUpdateMeeting', 'Itb\Controller\AdminController::processUpdateMeeting');


//$app['debug'] = true;
$app->error(function (\Exception $e, $code) use ($app) {
    $errorController = new Itb\Controller\ErrorController();
    return $errorController->errorAction($app, $code);
});


$app->run();
