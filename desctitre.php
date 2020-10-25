<?php
include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$GLOBALS['xoopsOption']['template_main'] = 'xentcareer_desctitre.html';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

function XENT_CR_DescTitre($id)
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $modules_tables;

    $temp = $id;

    $result = $xoopsDB->query('SELECT id_titres, titres, description FROM ' . $xoopsDB->prefix('xent_cr_titres') . " WHERE id_titres=$id");

    [$id_titres, $titres, $description] = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $description = $myts->displayTarea($description);

    $titres = $myts->displayTarea($titres);

    $xoopsTpl->assign('description', $description);

    $xoopsTpl->assign('titres', $titres);

    $form_select = new XoopsThemeForm(_MI_XENT_CR_FORMAPPLY, 'form_select', "desctitre.php?op=XENT_CR_DescTitre&id=$temp");

    $form_select->addElement(new XoopsFormHidden('op', 'XENT_CR_Formlist'));

    $object = new xoopsFormSelect('', 'titres_select', $id, 1, false);

    $result_all_titres = $xoopsDB->query('SELECT id_titres, titres, description FROM ' . $xoopsDB->prefix('xent_cr_titres'));

    while (list($id_titres, $titres, $description) = $xoopsDB->fetchRow($result_all_titres)) {
        $object->addOption($id_titres, $titres);
    }

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'submit', 'GO', 'submit'));

    $form_select->addElement($object);

    $form_select->addElement($button_tray);

    $form_select->assign($xoopsTpl);
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'XENT_CR_DescTitre':
    XENT_CR_DescTitre($id);
    break;
    case 'XENT_CR_Formlist':
        $id = $_POST['titres_select'];

        XENT_CR_DescTitre($id);
    break;
    default:
    $id = 1;
    XENT_CR_DescTitre($id);
    break;
}

include 'footer.php';
