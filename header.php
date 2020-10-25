<?php

include '../../mainfile.php';
//include "include/common.php";
//require XOOPS_ROOT_PATH.'/modules/mymodule/functions.php';
$versioninfo = $moduleHandler->get($xoopsModule->getVar('mid'));
$module_tables = $versioninfo->getInfo('tables');
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/class/xent_locations.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xentfunctions.php';
