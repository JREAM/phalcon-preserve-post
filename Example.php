<?php

// --------------------------------------------------------------
// 1: Setup a Dispatch Event Class
// --------------------------------------------------------------
class Dispatch
{

    // -------------------------------------------------------------

    public function beforeExecuteRoute($dispatcher)
    {
        if (!isset($_SESSION)) {
            return;
        }

        // Items to not preserve in formData
        $skipPostItems = [
            'password'
        ];

        // Clear the form data once the page reloads and it's viewable
        if ($_SESSION['formDataSeen'] >= 1) {
            $_SESSION['formData'] = null;
            $_SESSION['formDataSeen'] = null;
        }

        if (!empty($_POST))
        {
            foreach ($skipPostItems as $value)
            {
                if (isset($_POST[$value])) {
                    unset($_POST[$value]);
                }
            }

            $postData = [];
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                $value = strip_tags($value);
                $postData[$key] = $value;
            }
            // Store the Session Data
            $_SESSION['formData'] = $postData;
            $_SESSION['formDataSeen'] = -1;
        }

        if (isset($_SESSION['formDataSeen'])) {
            // Increments to 0 (false)
            // Once loaded again, increments to 1 (true)
            //      & Removed on next page load.
            ++$_SESSION['formDataSeen'];
        }
    }

    // -------------------------------------------------------------

    public function afterExecuteRoute($dispatcher){}

    // -------------------------------------------------------------

    public function beforeException($event, $dispatcher, $exception){}

    // -------------------------------------------------------------

}


// --------------------------------------------------------------
// 2: Require the dispatch file and put inside the DI
// --------------------------------------------------------------

$di->setShared('dispatcher', function() use ($di) {

    $eventsManager = $di->getShared('eventsManager');
    $eventsManager->attach('dispatch', new Dispatch());

    // -----------------------------------
    // Return the new dispatcher with the
    // Events Manager Attached
    // -----------------------------------
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});

// --------------------------------------------------------------
// 3: Optionally create a function for easy fetching
// ** This must come AFTER you instantiate the session within your bootstrap index.php
// --------------------------------------------------------------
function formData($name) {
    if (!isset($_SESSION)) {
        return false;
    }

    if (isset($_SESSION['formData']) && isset($_SESSION['formData'][$name])) {
        return $_SESSION['formData'][$name];
    }

    return false;
}



