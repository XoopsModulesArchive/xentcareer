<?php
include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
//require_once __DIR__ . '/include/functions.php';

$GLOBALS['xoopsOption']['template_main'] = 'xentcareer_joblist.html';

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

function XENT_CR_Admin($ordre, $ordtype)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsTpl, $xentLocations, $module_tables;

    if (1 == $ordtype) {
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix($module_tables[0]) . " ORDER BY $ordre DESC";

        $result = $xoopsDB->query($sql);

        $newordtype = 1;

        $ordtype = 0;
    } elseif (0 == $ordtype) {
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix($module_tables[0]) . " ORDER BY $ordre ASC";

        $result = $xoopsDB->query($sql);

        $newordtype = 0;

        $ordtype = 1;
    }

//    WHERE id_status=1

    $myts = MyTextSanitizer::getInstance();

    $count = 0;

    $i = 0;

    while (false !== ($cat_data = $xoopsDB->fetchArray($result))) {
        $count += 1;

        if (1 == $cat_data['id_status']) {
            $cat_data['id_titre'] = reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $cat_data['id_titre']);

            $cat_data['id_typeposte'] = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'typeposte', 'id_typeposte', $cat_data['id_typeposte']);

            $loc = $xentLocations->getLocation($cat_data['id_locations']);

            $city = $loc['city'];

            $state = $loc['state'];

            $country = $loc['country'];

            $locations = $myts->displayTarea($city . ', ' . $state . ', ' . $country, 1, 0, 1, 0);

            //$cat_data['id_locations'] = reference("xent_cr_locations", "locations", "id_locations", $cat_data['id_locations']);

            $cat_data['posted_date'] = formatTimestamp($cat_data['posted_date'], 'Y-m-d');

            $emplois['id'] = $cat_data['id_job'];

            $emplois['viewtitre'] = $cat_data['id_titre'];

            $emplois['typeposte'] = $cat_data['id_typeposte'];

            $emplois['locations'] = $locations;

            $emplois['jobposteddate'] = $cat_data['posted_date'];

            $emplois['count'] = $i;

            $xoopsTpl->append('emploisliste', $emplois);
        }  

        $i += 1;
    }

    $xoopsTpl->assign('lang_JOBTITLE', _MI_XENT_CR_CHANGEMENUITEM);

    $xoopsTpl->assign('lang_VIEWID', _MI_XENT_CR_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_XENT_CR_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_XENT_CR_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_XENT_CR_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWPOSTEDDATE', _MI_XENT_CR_VIEWPOSTEDDATE);

    $xoopsTpl->assign('ordre', $ordre);

    $xoopsTpl->assign('ordtype', $ordtype);

    $xoopsTpl->assign('ordtypelink', $newordtype);
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'XENT_CR_Admin':
    XENT_CR_Admin($ordre, $ordtype);
    break;
    /*case "XENT_CR_Fullview":
    XENT_CR_Fullview($row_pos, $ordre);
    break;*/
    default:
    $ordre = 'posted_date';
    $ordtype = 1;
    XENT_CR_Admin($ordre, $ordtype);
    break;
}

include 'footer.php';
