<?php

require '../app/core/Autoloader.php';


/**
 * @var string 
 */
$ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;

/**
 * @var string 
 */
$action = isset($_GET['action']) ? $_GET['action'] : null;

/**
 * @var string 
 */
$id = isset($_GET['id']) ? $_GET['id'] : null;

/**
 * @var array
 */
$url_params['controller'] = $ctrl === null ? 'ControllerPage' : 'Controller' . ucfirst($ctrl);
$url_params['action'] = $action === null ? 'defaultAction' : ucfirst($action) . 'Action';

extract($url_params);
call_user_func_array([new $controller, $action], [$id]);
