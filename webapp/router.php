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
Router::get('/',			     'HomeController/index');
Router::get('home/',			 'HomeController/index');
Router::post('home/login',		 'HomeController/login');
Router::post('login/',		     'HomeController/login');
Router::post('login/login',		 'HomeController/login');
Router::post('home/register',	 'HomeController/register');
Router::post('register/',        'HomeController/register');
Router::post('register/register','HomeController/register');
Router::get('logout/',      	 'HomeController/logout');

Router::get('profile/',          'ProfileController/index');
Router::post('profile/edit',     'ProfileController/edit');
Router::get('profile/charge',    'ProfileController/charge');

Router::get('backoffice/',       'BackofficeController/index');


Router::get('game/',			 'Middle/start');
Router::post('game/',			 'Middle/postHandler');












/************** End of URLEncoder Routing Rules ************************************/