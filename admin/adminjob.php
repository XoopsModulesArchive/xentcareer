<?php

require __DIR__ . '/admin_header.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();
 xoops_cp_header();
 echo $oAdminButton->renderButtons('adminjob');

function AdminJob($ordre)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xentLocations;

    OpenTable();

    echo "<h4 style='text-align:left;'>" . _AM_XENT_CR_CHANGEMENUITEM . "</h4>
        <form action='addserver.php' method='post'>
		<div align='right'><a href='addjob.php'>" . _AM_XENT_CR_MENU_ADMINADDJOB . "</a></div>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>

                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr class='bg3'>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_job'>" . _AM_XENT_CR_VIEWID . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_titre'>" . _AM_XENT_CR_VIEWTITRE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_typeposte'>" . _AM_XENT_CR_VIEWTYPEPOSTE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_locations'>" . _AM_XENT_CR_VIEWLOCATION . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=posted_date'>" . _AM_XENT_CR_VIEWPOSTEDDATE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=start_date'>" . _AM_XENT_CR_VIEWSTARTDDATE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=end_date'>" . _AM_XENT_CR_VIEWENDDATE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_status'>" . _AM_XENT_CR_VIEWSTATUS . '</a></b></td>
                <td><b>' . _AM_XENT_CR_VIEWFUNCTION . '</b></td>';

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status FROM ' . $xoopsDB->prefix('xent_cr_job') . " ORDER BY $ordre");

    $myts = MyTextSanitizer::getInstance();

    $i = 0;

    while (list($job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id) = $xoopsDB->fetchRow($result)) {
        //$description = htmlspecialchars($description);

        $titres = reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $titres_id);

        $typeposte = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'typeposte', 'id_typeposte', $typeposte_id);

        $loc = $xentLocations->getLocation($locations_id);

        $city = $loc['city'];

        $state = $loc['state'];

        $country = $loc['country'];

        $locations = $myts->displayTarea($city . ', ' . $state . ', ' . $country, 1, 0, 1, 0);

        $status = reference('xent_cr_status', 'status', 'id_status', $status_id);

        $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

        $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

        $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

        echo "<tr class='bg1'><td align='right'>$job_id</td>";

        echo "<td>$titres</td>";

        echo "<td>$typeposte</td>";

        echo "<td>$locations</td>";

        echo "<td>$jobposteddate</td>";

        echo "<td>$jobstartdate</td>";

        echo "<td>$jobenddate</td>";

        echo "<td>$status</td>";

        echo "<td><a href='../viewjob.php?op=XENT_CR_Fullview&row_pos=$i&ordre=$ordre'>" . _AM_XENT_CR_VIEW . "</a>&nbsp;&nbsp;<a href='addjob.php?op=EVEdit&job_id=$job_id'>" . _AM_XENT_CR_EDIT . "</a><a href='addjob.php?op=EVDel&amp;job_id=$job_id&amp;ok=0'>" . _AM_XENT_CR_DELETE . '</a></td>
                </tr>';

        $i += 1;
    }

    echo "</table>
        </td>
        </tr>
        </table>
        <div align='left'><a href='addjob.php'>" . _AM_XENT_CR_MENU_ADMINADDJOB . '</a></div>
        </form>';

    CloseTable();
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
        case 'AdminJob':
                AdminJob($ordre);
                break;
        default:
                $ordre = 'id_job';
                AdminJob($ordre);
                break;
}
xoops_cp_footer();
