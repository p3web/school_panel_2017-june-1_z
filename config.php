<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/2/17 AD
 * Time: 10:55
 */

// global function
ob_start();
session_cache_expire();
session_start();


// data model files
require_once "model/database/data.php";
require_once "model/language/lang.php";

// access files
require_once "model/access/key_facts_function.php";
require_once "model/access/access_teacherpanel.php";


// control files
require_once "control/utilities/session.php";
require_once "control/utilities/csv_file.php";
require_once "control/control_teacherpanel.php";
