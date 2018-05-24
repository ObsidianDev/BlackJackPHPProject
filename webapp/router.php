<?php
/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 02-05-2016
 * Time: 11:18
 */
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

Router::get('/',				'HomeController/index');
Router::get('home/',			'HomeController/index');
Router::get('home/index',		'HomeController/index');
Router::get('home/start',		'HomeController/start');
Router::get('login/',			'LoginController/index');
Router::post('login/',			'LoginController/login');
		 











/************** End of URLEncoder Routing Rules ************************************/