<?php
include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$GLOBALS['xoopsOption']['template_main'] = 'xentcareer_temoignageview.html';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();
foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}
function XENT_CR_Quote($quote_id)
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    $result = $xoopsDB->query('SELECT id, quote_nom, quote_pict, quote_titreposte, quote_typeposte, quote_location, quote_experience, quote_quotetitle, citation FROM ' . $xoopsDB->prefix('xent_cr_quote') . " WHERE id=$quote_id");

    [$id, $quote_nom, $quote_pict, $quote_titreposte, $quote_typeposte, $quote_location, $quote_experience, $quote_quotetitle, $citation] = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $titreposteid = $quote_titreposte;

    $quote_titreposte = reference('xent_cr_titres', 'titres', 'id_titres', $quote_titreposte);

    $quote_typeposte = reference('xent_cr_typeposte', 'typeposte', 'id_typeposte', $quote_typeposte);

    $quote_location = reference('xent_cr_locations', 'locations', 'id_locations', $quote_location);

    $citation = $myts->displayTarea($citation);

    $quote_experience = $myts->displayTarea($quote_experience);

    $quote_quotetitle = $myts->displayTarea($quote_quotetitle);

    $upldir = $xoopsModuleConfig['sbuploaddir_quote'];

    $pict = XOOPS_URL . "$upldir/$quote_pict";

    $xoopsTpl->assign('id', $id);

    $xoopsTpl->assign('quote_nom', $quote_nom);

    $xoopsTpl->assign('quote_pict', $pict);

    $xoopsTpl->assign('quote_titreposte', $quote_titreposte);

    $xoopsTpl->assign('quote_typeposte', $quote_typeposte);

    $xoopsTpl->assign('quote_location', $quote_location);

    $xoopsTpl->assign('quote_experience', $quote_experience);

    $xoopsTpl->assign('quote_quotetitle', $quote_quotetitle);

    $xoopsTpl->assign('citation', $citation);

    $xoopsTpl->assign('LANG_typeposte', _MI_XENT_CR_TYPEPOSTE);

    $xoopsTpl->assign('LANG_nom', _MI_XENT_CR_NOM);

    $xoopsTpl->assign('LANG_titreposte', _MI_XENT_CR_POSTEOCCUPE);

    $xoopsTpl->assign('LANG_location', _MI_XENT_CR_LOCATIONS);

    $xoopsTpl->assign('LANG_experience', _MI_XENT_CR_EXPERIENCE);

    $xoopsTpl->assign('LANG_viewotherquote', _MI_XENT_CR_VIEWOTHERQUOTE);

    $xoopsTpl->assign('titreposte_id', $titreposteid);
}
$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
case 'XENT_CR_Quote':
XENT_CR_Quote($quote_id);
break;
default:
redirect_header('temoignagelist.php', 1, _MI_XENT_CR_RETURNTOINDEX);
exit;
break;
}
include 'footer.php';
