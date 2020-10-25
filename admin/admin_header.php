<?php
require __DIR__ . '/admin_buttons.php';
include '../../../mainfile.php';
require dirname(__DIR__, 3) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsmodule.php';
require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//require_once dirname(__DIR__) . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/class/xent_locations.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xentfunctions.php';

if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname('xentcareer');

    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 1, _NOPERM);

        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/', 1, _NOPERM);

    exit();
}

//require_once XOOPS_ROOT_PATH."/modules/xentcareer/include/functions.php";

global $xoopsModule;

$module_id = $xoopsModule->getVar('mid');
$oAdminButton = new AdminButtons();
$oAdminButton->AddTitle(_AM_XENT_CR_MENU_ADMIN_TITLE);

//$oAdminButton->AddButton(_AM_XENT_CR_MENU_INDEX, "index.php", 'index');
$oAdminButton->AddButton(_AM_XENT_CR_MENU_ADMINJOB, 'adminjob.php', 'adminjob');
//$oAdminButton->AddButton(_AM_XENT_CR_MENU_ADMINADDJOB, "addjob.php", 'adminaddjob');
//$oAdminButton->AddButton(_AM_XENT_CR_MENU_ADMINQUOTE, "quote.php", 'adminquote');
//$oAdminButton->AddButton(_AM_XENT_CR_MENU_ADMINADDQUOTE, "quote.php?op=AddNewQuote", 'adminaddquote');
$oAdminButton->AddButton(_AM_XENT_CR_MENU_ADMINCV, 'admincv.php', 'admincv');
//$oAdminButton->addButton(_AM_XENT_CR_MENU_MENULINK, "menulink.php", 'menulink');
$oAdminButton->AddButton(_AM_XENT_CR_MENU_ADMIN_CAT, 'options.php', 'options');

//$oAdminButton->AddTopLink(_AM_XENT_CR_ADMIN_CAT, "options.php");
$oAdminButton->AddTopLink(_AM_XENT_CR_MENU_PREFERENCES, XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $module_id);
$oAdminButton->addTopLink(_AM_XENT_CR_MENULINK_TITLE, XOOPS_URL . '/modules/xentgen/admin/adminjobs.php');
$oAdminButton->AddTopLink(_AM_XENT_CR_MENU_REPERTOIRECHECK, 'setupfolder.php');
$oAdminButton->addTopLink(_AM_XENT_CR_MENU_UPDATE_MODULE, XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=xentcareer');

$myts = MyTextSanitizer::getInstance();
