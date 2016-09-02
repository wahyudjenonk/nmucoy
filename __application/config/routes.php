<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "frontend";
$route['404_override'] = '';

//Frontend 
//Display
$route['logout'] = 'frontend';
//$route['login'] = 'frontend/getdisplay/__loginuser';
$route['register'] = 'frontend/getdisplay/__registeruser';

//Action, Crud
$route['register-account'] = 'frontend/simpansavedbx/__registeraccount';
$route['in'] = 'login/login_frontend';
$route['out'] = 'login/logout_frontend';

//End FrontEnd


/* End of file routes.php */
/* Location: ./application/config/routes.php */