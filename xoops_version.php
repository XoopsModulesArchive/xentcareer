<?php
// ------------------------------------------------------------------------- //
//                    Module Carrière pour Xoops 2.0.7                       //
//                              Version:  1.0                                //
// ------------------------------------------------------------------------- //
// Author: Yoyo2021                                        				     //
// Purpose: Module Carrière                          				 //
// email: info@fpsquebec.net                                                 //
// URLs: http://www.fpsquebec.net                      //
//---------------------------------------------------------------------------//
global $xoopsModuleConfig;
$modversion['name'] = _MI_XENT_CR_NAME;
$modversion['version'] = '1.2';
$modversion['description'] = _MI_XENT_CR_DESC;
$modversion['credits'] = 'Mathieu Delisle (info@site3web.net)';
$modversion['author'] = 'Ecrit pour Xoops2<br>par MAthieu Delisle (Yoyo2021)<br>http://www.site3web.net';
$modversion['license'] = '';
$modversion['official'] = 1;
$modversion['image'] = 'images/xentcarriere.png';
$modversion['help'] = '';
$modversion['dirname'] = 'xentcareer';

// MYSQL FILE
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
//If you hack this modules, dont change the order of the table.
//All
$modversion['tables'][0] = 'xent_cr_job';
$modversion['tables'][1] = 'xent_cr_status';
$modversion['tables'][2] = 'xent_cr_reference';
$modversion['tables'][3] = 'xent_cr_cv';

$modversion['onInstall'] = 'include/installscript.php';
//$modversion['onUninstall'] = 'include/uninstallscript.php';

$modversion['templates'][1]['file'] = 'xentcareer_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'xentcareer_joblist.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'xentcareer_jobview.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'xentcareer_jobform.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'xentcareer_desctitre.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'xentcareer_sendfriend.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'xentcareer_refform.html';
$modversion['templates'][7]['description'] = '';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_XENT_CR_SMNAME1;
$modversion['sub'][1]['url'] = 'emplois.php';
$modversion['sub'][2]['name'] = _MI_XENT_CR_SMNAME2;
$modversion['sub'][2]['url'] = 'temoignagelist.php';

// Blocks
$modversion['blocks'][1]['file'] = 'xentcareer_block.php';
$modversion['blocks'][1]['name'] = _MI_XENT_CR_BNAME1;
$modversion['blocks'][1]['description'] = 'Affiche les 5 derniers postes disponibles. ';
$modversion['blocks'][1]['show_func'] = 'xentcareer_show'; // fonction affichage du bloc
$modversion['blocks'][1]['template'] = 'xentcareer_block.html';

//CONFIGUE

/*$modversion['config'][2]['name'] = 'maximgwidth';
$modversion['config'][2]['title'] = '_MI_XENT_CR_IMGWIDTH';
$modversion['config'][2]['description'] = '_MI_XENT_CR_IMGWIDTHDSC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 800;

$modversion['config'][3]['name'] = 'maximgheight';
$modversion['config'][3]['title'] = '_MI_XENT_CR_IMGHEIGHT';
$modversion['config'][3]['description'] = '_MI_XENT_CR_IMGHEIGHTDSC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 800;

$modversion['config'][4]['name'] = 'sbuploaddir_quote';
$modversion['config'][4]['title'] = '_MI_XENT_CR_UPLOADDIR_QUOTE';
$modversion['config'][4]['description'] = '_MI_XENT_CR_UPLOADDIRDSC_QUOTE';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = '/uploads/xentcareer/temoignage';*/

$modversion['config'][1]['name'] = 'sbuploaddir_cv';
$modversion['config'][1]['title'] = '_MI_XENT_CR_UPLOADDIR_CV';
$modversion['config'][1]['description'] = '_MI_XENT_CR_UPLOADDIRDSC_CV';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = '/uploads/xentsite/cv';

$modversion['config'][2]['name'] = 'image_extention';
$modversion['config'][2]['title'] = '_MI_XENT_CR_IMAGEEXTENTION';
$modversion['config'][2]['description'] = '_MI_XENT_CR_IMAGEEXTENTIONDSC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'image/gif;image/jpg;image/x-png';

$modversion['config'][3]['name'] = 'cv_extention';
$modversion['config'][3]['title'] = '_MI_XENT_CR_CVEXTENTION';
$modversion['config'][3]['description'] = '_MI_XENT_CR_CVEXTENTIONDSC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'text';
$modversion['config'][3]['default'] = 'application/pdf;application/msword';

$modversion['config'][4]['name'] = 'dateformat';
$modversion['config'][4]['title'] = '_MI_XENT_CR_DATEFORMAT';
$modversion['config'][4]['description'] = '_MI_XENT_CR_DATEFORMATDSC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = 'd-M-Y';

$modversion['config'][5]['name'] = 'emailrh';
$modversion['config'][5]['title'] = '_MI_XENT_CR_EMAILRH';
$modversion['config'][5]['description'] = '_MI_XENT_CR_EMAILRHDESC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = $xoopsConfig['adminmail'];

$modversion['config'][6]['name'] = 'xent_cr_intro';
$modversion['config'][6]['title'] = '_MI_XENT_CR_INTRO';
$modversion['config'][6]['description'] = '_MI_XENT_CR_INTRODESC';
$modversion['config'][6]['formtype'] = 'textarea';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = '[fr]Introduction[/fr][en]Introduction[/en]';

$modversion['config'][7]['name'] = 'xent_cr_cie';
$modversion['config'][7]['title'] = '_MI_XENT_CR_CIE';
$modversion['config'][7]['description'] = '_MI_XENT_CR_CIEDESC';
$modversion['config'][7]['formtype'] = 'textbox';
$modversion['config'][7]['valuetype'] = 'text';
$modversion['config'][7]['default'] = '';

$modversion['config'][8]['name'] = 'sendbymail';
$modversion['config'][8]['title'] = '_MI_XENT_CR_SENDBYMAIL';
$modversion['config'][8]['description'] = '_MI_XENT_CR_SENDBYMAILDSC';
$modversion['config'][8]['formtype'] = 'yesno';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 1;

$modversion['config'][9]['name'] = 'savedb';
$modversion['config'][9]['title'] = '_MI_XENT_CR_SAVEDB';
$modversion['config'][9]['description'] = '_MI_XENT_CR_SAVEDBDSC';
$modversion['config'][9]['formtype'] = 'yesno';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 1;

$modversion['config'][10]['name'] = 'departementname';
$modversion['config'][10]['title'] = '_MI_XENT_CR_DEPARTEMENTNAME';
$modversion['config'][10]['description'] = '_MI_XENT_CR_DEPARTEMENTNAMEDSC';
$modversion['config'][10]['formtype'] = 'textbox';
$modversion['config'][10]['valuetype'] = 'text';
$modversion['config'][10]['default'] = 'Ressources Humaines';

$modversion['config'][11]['name'] = 'modinteract_tt';
$modversion['config'][11]['title'] = '_MI_XENT_CR_MODINTERACT_TT';
$modversion['config'][11]['description'] = '_MI_XENT_CR_MODINTERACT_TTDSC';
$modversion['config'][11]['formtype'] = 'yesno';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 0;

$modversion['config'][12]['name'] = 'maxfilesize';
$modversion['config'][12]['title'] = '_MI_XENT_CR_MAXFILESIZE';
$modversion['config'][12]['description'] = '_MI_XENT_CR_MAXFILESIZEDSC';
$modversion['config'][12]['formtype'] = 'textbox';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 250000;
/*$modversion['config'][12]['name'] = 'xent_cr_valeur';
$modversion['config'][12]['title'] = '_MI_XENT_CR_VALEUR';
$modversion['config'][12]['description'] = '_MI_XENT_CR_VALEURDESC';
$modversion['config'][12]['formtype'] = 'textarea';
$modversion['config'][12]['valuetype'] = 'text';
$modversion['config'][12]['default'] = '[fr][/fr][en][/en]';*/
