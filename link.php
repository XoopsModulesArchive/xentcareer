<?php
include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

global $xoopsModuleConfig;
$GLOBALS['xoopsOption']['template_main'] = 'xentcareer_index.html';
$xoopsTpl->assign('lang_XENT_CR_TITLE', _MI_XENT_CR_TITLE);
$xoopsTpl->assign('XENT_CR_INTRO', $xoopsModuleConfig['xent_cr_intro']);

include 'footer.php';
