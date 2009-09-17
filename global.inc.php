<?php
/**
 * OurBB, a small but effective Burning Board
 *
 * Copyright (C) 2009 Dustin Steiner
 *
 * This work is licensed under the Creative Commons Attribution-Share Alike 3.0 Austria License.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/at/ or send a letter to
 *  Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
 */

// first start the session to prevent output problems
session_start();
session_name('OurBB');

// include the most important file
require('config.inc.php');

// include MySQL-class and create an object
require('lib/MySQL.class.php');
$db = new MySQL($sqlHost, $sqlUser, $sqlPassword, $sqlDB);
unset($sqlHost, $sqlUser, $sqpPassword);
define('DB_PREFIX', $dbPrefix);

// include the options
require('lib/options.inc.php');

// include the Template-class and create an object
require('lib/Template.class.php');
//TODO: create object

// include the global functions that are needed
require("lib/functions.php");

// include the User-class and create an object to manage the users session
require('lib/User.class.php');
//TODO: create class and object

/*
$menu_usercp_link = ($isUser == true ? '<a href="./usercp.php">UserCP</a>' : '<a href="./register.php">Registrieren</a>');
$menu_specialsearch_link = ($isUser == true ? '<a href="./search.php?do=new">Neue Beitr&auml;ge</a>' : '<a href="./search.php?do=today">Heutige Beitr&auml;ge</a>');
$menu_logout_link = ($isUser == true ? '<td><a href="./login.php?do=logout">Abmelden</a></td>' : '');
$username = ($isUser == true ? $_SESSION['username'] : 'Gast');
$login_logout_menu = ($isUser == true ? '<a href="./login.php?do=logout">Logout</a>' : '<a href="./login.php">Login</a>');

eval ("\$headinclude = \"".gettemplate("headinclude")."\";");
eval ("\$header = \"".gettemplate("header")."\";");
eval ("\$footer = \"".gettemplate("footer")."\";");
*/
?>
