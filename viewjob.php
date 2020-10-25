<?php
include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$GLOBALS['xoopsOption']['template_main'] = 'xentcareer_jobview.html';

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

function XENT_CR_Fullview($row_pos, $ordre, $ordtype)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsTpl, $module_tables, $xentLocations;

    $myts = MyTextSanitizer::getInstance();

    //$sql = "SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ".$xoopsDB->prefix($module_tables[0])." ORDER BY $ordre";

    if (1 == $ordtype) {
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix($module_tables[0]) . " ORDER BY $ordre DESC";
    } elseif (0 == $ordtype) {
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix($module_tables[0]) . " ORDER BY $ordre ASC";
    }

    // $result va retourner la rangée qui se trouve à la position $row_pos, genre la 6e ligne, peut importe le job_id

    $result = $xoopsDB->query($sql, 1, $row_pos);

    // Si result retourne False, ca veut dire que la requete n'a rien retourner, donc t au debut ou a la fin de la table

    if (!($result)) {
        redirect_header('emplois.php', 1, _MI_XENT_CR_RETURNTOINDEX);

        exit;
    }

    if ($row_pos < 0) {
        redirect_header('emplois.php', 1, _MI_XENT_CR_RETURNTOINDEX);

        exit;
    }

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id, $description, $exigence] = $xoopsDB->fetchRow($result);

    $titreposteid = $titres_id;

    $titres = reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $titres_id);

    $typeposte = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'typeposte', 'id_typeposte', $typeposte_id);

    $loc = $xentLocations->getLocation($locations_id);

    $city = $loc['city'];

    $state = $loc['state'];

    $country = $loc['country'];

    $locations = $myts->displayTarea($city . ', ' . $state . ', ' . $country, 1, 0, 1, 0);

    //$locations = reference($module_tables[1], "locations", "id_locations", $locations_id);

    $status = reference($module_tables[2], 'status', 'id_status', $status_id);

    $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

    $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

    $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

    $description = $myts->displayTarea($description, 1, 0, 1, 0);

    $exigence = $myts->displayTarea($exigence, 1, 0, 1, 0);

    // incrémente les valeurs...

    $last = $row_pos - 1;

    $next = $row_pos + 1;

    $xoopsTpl->assign('lang_VIEWID', _MI_XENT_CR_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_XENT_CR_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_XENT_CR_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_XENT_CR_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWSTATUS', _MI_XENT_CR_VIEWSTATUS);

    $xoopsTpl->assign('lang_VIEWSTARTDDATE', _MI_XENT_CR_VIEWSTARTDDATE);

    $xoopsTpl->assign('lang_VIEWENDDATE', _MI_XENT_CR_VIEWENDDATE);

    $xoopsTpl->assign('lang_JOBDESC', _MI_XENT_CR_JOBDESC);

    $xoopsTpl->assign('lang_JOBEXIG', _MI_XENT_CR_JOBEXIG);

    $xoopsTpl->assign('lang_JOBTITRE', _MI_XENT_CR_JOBTITRE);

    $xoopsTpl->assign('xent_cr_job_id', $job_id);

    $xoopsTpl->assign('xent_cr_jobposteddate', $jobposteddate);

    $xoopsTpl->assign('xent_cr_titres', $titres);

    $xoopsTpl->assign('xent_cr_typeposte', $typeposte);

    $xoopsTpl->assign('xent_cr_locations', $locations);

    $xoopsTpl->assign('xent_cr_status', $status);

    $xoopsTpl->assign('xent_cr_jobstartdate', $jobstartdate);

    $xoopsTpl->assign('xent_cr_jobenddate', $jobenddate);

    $xoopsTpl->assign('xent_cr_description', $description);

    $xoopsTpl->assign('xent_cr_exigence', $exigence);

    $xoopsTpl->assign('titreposte_id', $titreposteid);

    $postuler = new XoopsThemeForm('jobapply', 'postuler', "jobapply.php?job_id=$job_id");

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'postuler'));

    $postuler->addElement(new XoopsFormHidden('prenom', ''));

    $postuler->addElement(new XoopsFormHidden('nom', ''));

    $postuler->addElement(new XoopsFormHidden('email', ''));

    $postuler->addElement(new XoopsFormHidden('address', ''));

    $postuler->addElement(new XoopsFormHidden('ville', ''));

    $postuler->addElement(new XoopsFormHidden('zipcode', ''));

    $postuler->addElement(new XoopsFormHidden('telhome', ''));

    $postuler->addElement(new XoopsFormHidden('telcell', ''));

    $postuler->addElement(new XoopsFormHidden('telautre', ''));

    $postuler->addElement(new XoopsFormHidden('heardodesia', ''));

    $postuler->addElement(new XoopsFormHidden('nomress', ''));

    $postuler->addElement(new XoopsFormHidden('emailress', ''));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_XENT_CR_POSTULER, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    $sendtofriend = new XoopsThemeForm('sendtofriend', 'sendtofriend', "sendfriend.php?job_id=$job_id");

    $sendtofriend->addElement(new XoopsFormHidden('job_id', $job_id));

    $sendtofriend->addElement(new XoopsFormHidden('op', 'sendtofriend'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_XENT_CR_SENDTOFRIEND, 'submit'));

    $sendtofriend->addElement($button_tray);

    $sendtofriend->assign($xoopsTpl);
}

function XENT_CR_FullviewByID($job_id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsTpl, $module_tables, $xentLocations;

    if ($job_id < 0) {
        redirect_header('emplois.php', 1, _MI_XENT_CR_RETURNTOINDEX);

        exit;
    }

    $myts = MyTextSanitizer::getInstance();

    //$sql = "SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ".$xoopsDB->prefix("xent_cr_job")." ORDER BY $ordre";

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix($module_tables[0]) . " WHERE id_job=$job_id");

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id, $description, $exigence] = $xoopsDB->fetchRow($result);

    $titres = reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $titres_id);

    $typeposte = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'typeposte', 'id_typeposte', $typeposte_id);

    $loc = $xentLocations->getLocation($locations_id);

    $city = $loc['city'];

    $state = $loc['state'];

    $country = $loc['country'];

    $locations = $myts->displayTarea($city . ', ' . $state . ', ' . $country, 1, 0, 1, 0);

    //$locations = reference($module_tables[1], "locations", "id_locations", $locations_id);

    $status = reference($module_tables[1], 'status', 'id_status', $status_id);

    $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

    $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

    $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

    $description = $myts->displayTarea($description, 1, 0, 1, 0);

    $exigence = $myts->displayTarea($exigence, 1, 0, 1, 0);

    $xoopsTpl->assign('lang_VIEWID', _MI_XENT_CR_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_XENT_CR_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_XENT_CR_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_XENT_CR_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWSTATUS', _MI_XENT_CR_VIEWSTATUS);

    $xoopsTpl->assign('lang_VIEWSTARTDDATE', _MI_XENT_CR_VIEWSTARTDDATE);

    $xoopsTpl->assign('lang_VIEWENDDATE', _MI_XENT_CR_VIEWENDDATE);

    $xoopsTpl->assign('lang_JOBDESC', _MI_XENT_CR_JOBDESC);

    $xoopsTpl->assign('lang_JOBEXIG', _MI_XENT_CR_JOBEXIG);

    $xoopsTpl->assign('lang_JOBTITRE', _MI_XENT_CR_JOBTITRE);

    $xoopsTpl->assign('xent_cr_job_id', $job_id);

    $xoopsTpl->assign('xent_cr_jobposteddate', $jobposteddate);

    $xoopsTpl->assign('xent_cr_titres', $titres);

    $xoopsTpl->assign('xent_cr_typeposte', $typeposte);

    $xoopsTpl->assign('xent_cr_locations', $locations);

    $xoopsTpl->assign('xent_cr_status', $status);

    $xoopsTpl->assign('xent_cr_jobstartdate', $jobstartdate);

    $xoopsTpl->assign('xent_cr_jobenddate', $jobenddate);

    $xoopsTpl->assign('xent_cr_description', $description);

    $xoopsTpl->assign('xent_cr_exigence', $exigence);

    $postuler = new XoopsThemeForm('jobapply', 'postuler', 'jobapply.php');

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'postuler'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_XENT_CR_POSTULER, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    $sendtofriend = new XoopsThemeForm('sendtofriend', 'sendtofriend', 'sendfriend.php');

    $sendtofriend->addElement(new XoopsFormHidden('job_id', $job_id));

    $sendtofriend->addElement(new XoopsFormHidden('op', 'sendtofriend'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_XENT_CR_SENDTOFRIEND, 'submit'));

    $sendtofriend->addElement($button_tray);

    $sendtofriend->assign($xoopsTpl);
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'XENT_CR_Fullview':
    XENT_CR_Fullview($row_pos, $ordre, $ordtype);
    break;
    case 'XENT_CR_FullviewByID':
    XENT_CR_FullviewByID($job_id);
    break;
    default:
    redirect_header('emplois.php', 1, _MI_XENT_CR_RETURNTOINDEX);
        exit;
    break;
}

include 'footer.php';
