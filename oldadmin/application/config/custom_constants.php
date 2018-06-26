<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Set Permission to add controller under another controllers
*/

/*
 * $this->config->item('Admin')
*/

/*
 * Controller Types*/

$config['ProductionControllers'] = array(
    'Area Production Controller',
    'Plant Production Controller',
    'Industrial Production Controller',
    'Production Jobber'
);

$config['SalesControllers'] = array(
    'Area Sales Controller',
    'Plant Sales Controller',
    'Industrial Sales Controller',
    'Sales Jobber'
);

/*Controllera Urls*/
$config['ProductionControllerUrls'] = array(
    'Area Production Controller'=>'production/arealist',
    'Plant Production Controller'=>'production/plantlist',
    'Industrial Production Controller'=>'production/industriallist',
    'Production Jobber'=>'production/jobberlist'
);

$config['SalesControllerUrls'] = array(
    'Area Sales Controller'=>'sales/arealist',
    'Plant Sales Controller'=>'sales/plantlist',
    'Industrial Sales Controller'=>'sales/industriallist',
    'Sales Jobber'=>'sales/jobberlist'
);

/*Controllers under Admin*/

$config['Admin'] = array(
    'Area Production Controller',
    'Plant Production Controller',
    'Industrial Production Controller',
    'Production Jobber',
    'Area Sales Controller',
    'Plant Sales Controller',
    'Industrial Sales Controller',
    'Sales Jobber'
);


/* Variable used for looping*/
$config['AdminVarialbles'] = array(
    'Area Production Controller'=>'p_area',
    'Plant Production Controller'=>'p_plant',
    'Industrial Production Controller'=>'p_industrial',
    'Production Jobber'=>'p_jobber',
    'Area Sales Controller'=>'s_area',
    'Plant Sales Controller'=>'s_plant',
    'Industrial Sales Controller'=>'s_industrial',
    'Sales Jobber'=>'s_jobber'
);

$config['AdminUrls'] = array(
    'Area Production Controller'=>'production/arealist',
    'Plant Production Controller'=>'production/plantlist',
    'Industrial Production Controller'=>'production/industriallist',
    'Production Jobber'=>'production/jobberlist',
    'Area Sales Controller'=>'sales/arealist',
    'Plant Sales Controller'=>'sales/plantlist',
    'Industrial Sales Controller'=>'sales/industriallist',
    'Sales Jobber'=>'sales/jobberlist'
);

/*Controllers Under other users*/

$config['Area Production Controller'] = array(
    'Plant Production Controller',
    'Industrial Production Controller',
    'Production Jobber'
);

$config['Area Sales Controller'] = array(
    'Plant Sales Controller',
    'Industrial Sales Controller',
    'Sales Jobber'
);

$config['Plant Production Controller'] = array(
    'Industrial Production Controller',
    'Production Jobber'
);

$config['Plant Sales Controller'] = array(
    'Industrial Sales Controller',
    'Sales Jobber'
);

$config['Industrial Production Controller'] = array(
    'Production Jobber'
);

$config['Industrial Sales Controller'] = array(
    'Sales Jobber'
);
