<?php
require dirname(__DIR__, 3) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once dirname(__DIR__) . '/include/functions.php';
if (file_exists('../language/' . $xoopsConfig['language'] . '/main.php')) {
    include '../language/' . $xoopsConfig['language'] . '/main.php';
} else {
    include '../language/francais/main.php';
}
foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();
xoops_cp_header();
menucv();
function EVAdmin()
{
}
function EVEdit($id_cv)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xent_cr_cv') . " WHERE id=$id_cv");

    [$id, $name, $family_name, $email, $address, $city, $province, $country, $zipcode, $tel_home, $tel_cell, $tel_other, $cv, $rec_letter, $heard_odesia, $rec_name, $rec_email, $id_poste] = $xoopsDB->fetchRow($result);

    OpenTable();

    $sform = new XoopsThemeForm(_AM_XENT_CR_FORMNAME, 'editjob', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText('Nom :', 'cv_name', 50, 255, $name . ' ' . $family_name));

    $sform->addElement(new XoopsFormText('Email :', 'cv_email', 50, 255, $email));

    $sform->addElement(new XoopsFormText('Adresse :', 'cv_address', 50, 255, $address));

    $sform->addElement(new XoopsFormText('Ville :', 'cv_city', 50, 255, $city));

    $sform->addElement(new XoopsFormText('Province :', 'cv_province', 50, 255, $province));

    $sform->addElement(new XoopsFormText('Pays :', 'cv_country', 50, 255, $country));

    $sform->addElement(new XoopsFormText('Code Postal :', 'cv_zipcode', 50, 255, $zipcode));

    $sform->addElement(new XoopsFormText('Téléphone à la maison :', 'cv_telhome', 50, 255, $tel_home));

    $sform->addElement(new XoopsFormText('Téléphone cellulaire :', 'cv_telcell', 50, 255, $tel_cell));

    $sform->addElement(new XoopsFormText('Téléphone autre :', 'cv_telother', 50, 255, $tel_other));

    $sform->addElement(new XoopsFormText('CV :', 'cv_cv', 50, 255, $cv));

    $sform->addElement(new XoopsFormText('Lettre de recommandation :', 'cv_rec', 50, 255, $rec));

    $sform->addElement(new XoopsFormText("Entendu parler d'ODESIA ? :", 'cv_heardodesia', 50, 255, $heard_odesia));

    $sform->addElement(new XoopsFormText('Personne ressource :', 'cv_ressname', 50, 255, $rec_name . ' (' . $rec_email . ')'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'add', _MI_XENT_CR_SAVE, 'submit'));

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'EVSave'));

    $sform->display();

    CloseTable();
}
function EVDel($id_cv, $ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if (1 == $ok) {
        $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix('xent_cr_cv') . " WHERE id=$id_cv");

        redirect_header('admincv.php', 1, _AM_PGSA_DBUPDATED);

        exit();
    }  

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT id, name, family_name, cv, rec_letter FROM ' . $xoopsDB->prefix('xent_cr_cv') . " WHERE id=$id_cv");

    [$id, $name, $family_name, $cv, $rec_letter] = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $titres = reference('xent_cr_titres', 'titres', 'id_titres', $titres_id);

    $typeposte = reference('xent_cr_typeposte', 'typeposte', 'id_typeposte', $typeposte_id);

    $locations = reference('xent_cr_locations', 'locations', 'id_locations', $locations_id);

    $status = reference('xent_cr_status', 'status', 'id_status', $status_id);

    $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

    $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

    $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

    OpenTable();

    echo "
<form action='addserver.php' method='post'>
<input type='hidden' name='job_id' value='$job_id'>
<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
<tr>
<td class='bg2'>
<table border='0' cellpadding='4' cellspacing='1' width='100%'>
 <tr>
 <td class='bg3' width='200'></td>
 <td class='bg3'></td>
 </tr>
 <tr>
 <td class='bg3'><b>" . _AM_XENT_CR_NAME . "</b></td>
 <td class='bg1'>" . $name . ' ' . $family_name . "</td>
 </tr>
 <tr>
 <td class='bg3'><b>" . _AM_XENT_CR_CV . "</b></td>
 <td class='bg1'>" . $cv . "</td>
 </tr>
 <tr>
 <td class='bg3'><b>" . _AM_XENT_CR_LR . "</b></td>
 <td class='bg1'>" . $rec . '</td>
 </tr>
</table>
</td>
</tr>
</table>
</form>
';

    echo "<table valign='top'><tr>";

    echo "<td width='30%'valign='top'><span style='color:#ff0000;'><b>" . _AM_PGSA_WANTDEL . '</b></span></td>';

    echo "<td width='3%'>\n";

    echo myTextForm("addcv.php?op=EVDel&id_cv=$id&ok=1", _AM_XENT_CR_YES);

    echo "</td><td>\n";

    echo myTextForm('admincv.php', _AM_XENT_CR_NO);

    echo "</td></tr></table>\n";

    CloseTable();
}
function EVSave($job_id, $titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $jobstartdate = strtotime($jobstartdate);

    $jobenddate = strtotime($jobenddate);

    //Recuperer la date:

    //$date2 = formatTimeStamp($jobposteddate, 'Y-m-d');

    //echo $date2;

    $description = $myts->addSlashes($description);

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('xent_cr_job') . " SET id_titre='$titres_id', id_typeposte='$typeposte_id', id_locations='$locations_id', start_date='$jobstartdate', end_date='$jobenddate', id_status='$status_id', description='$description' WHERE id_job=$job_id");

    redirect_header('index.php', 1, _AM_XENT_CR_DBUPDATED);

    exit();
}
$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
case 'EVDel':
EVDel($id_cv, $ok);
break;
case 'EVAddjob':
EVAddjob($titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description);
break;
case 'EVAdmin':
EVAdmin();
break;
case 'EVEdit':
EVEdit($id_cv);
break;
default:
EVDispl();
break;
}
xoops_cp_footer();
