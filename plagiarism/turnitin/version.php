<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$plugin->version = 2014031800;
$plugin->requires =  2012062500.00;
$plugin->cron     = 300;
$plugin->component = 'plagiarism_turnitin';
$plugin->maturity  = MATURITY_STABLE;

$plugin->dependencies = array('mod_turnitintooltwo' => 2014012402);