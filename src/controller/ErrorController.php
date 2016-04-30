<?php

namespace Itb\Controller;

use Silex\Application;

class ErrorController
{
    public function errorAction(Application $app, $code)
    {
        // default - assume a 404 error
        $argsArray = [];
        $templateName = '404';

        if (404 != $code) {
            $argsArray = [
                'message' => 'sorry - an unknown error occurred'
            ];
            $templateName = 'error';
        }

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

}