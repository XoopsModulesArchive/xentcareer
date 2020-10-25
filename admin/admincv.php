<?php

require __DIR__ . '/admin_header.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('admincv');

function Admincv($ordre)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    OpenTable();

    echo "<h4 style='text-align:left;'>" . _AM_XENT_CR_CVMENUITEM . "</h4>
        <form action='addserver.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr class='bg3'>
                <td><b><a href='admincv.php?op=Admincv&ordre=id_job'>" . 'NOM' . '</a></b></td>
                <td><b>' . _AM_XENT_CR_VIEWFUNCTION . '</b></td></tr>';

    $result = $xoopsDB->query('SELECT id, name, family_name FROM ' . $xoopsDB->prefix('xent_cr_cv'));

    $myts = MyTextSanitizer::getInstance();

    $i = 0;

    while (list($id, $name, $family_name) = $xoopsDB->fetchRow($result)) {
        //$description = htmlspecialchars($description);

        //$titres = reference("xent_cr_titres", "titres", "id_titres", $titres_id);

        $id_cv = $id;

        echo "<td bgcolor=ffffff>$name" . ' ' . $family_name . '</td>';

        echo "<td bgcolor=ffffff><a href='admincv.php?op=EVDisplay&id_cv=$id_cv'>" . _AM_XENT_CR_VIEW . "</a><a href='admincv.php?op=EVEdit&id_cv=$id_cv'>" . _AM_XENT_CR_EDIT . "</a><a href='admincv.php?op=EVDel&amp;id_cv=$id_cv&amp;ok=0'>" . _AM_XENT_CR_DELETE . '</a></td>
                </tr>';

        $i += 1;
    }

    echo '</table>
        </td>
        </tr>
        </table>
        </form>';

    CloseTable();
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

    $sform->addElement(new XoopsFormHidden('id_cv', $id));

    $sform->addElement(new XoopsFormText('Prénom :', 'name', 50, 255, $name));

    $sform->addElement(new XoopsFormText(_AM_XENT_CR_NAME, 'family_name', 50, 255, $family_name));

    $sform->addElement(new XoopsFormText('Email :', 'email', 50, 255, $email));

    $sform->addElement(new XoopsFormText('Adresse :', 'address', 50, 255, $address));

    $sform->addElement(new XoopsFormText('Ville :', 'city', 50, 255, $city));

    $sform->addElement(new XoopsFormText('Province :', 'province', 50, 255, $province));

    $sform->addElement(new XoopsFormText('Pays :', 'country', 50, 255, $country));

    $sform->addElement(new XoopsFormText('Code Postal :', 'zipcode', 50, 255, $zipcode));

    $sform->addElement(new XoopsFormText('Téléphone à la maison :', 'telhome', 50, 255, $tel_home));

    $sform->addElement(new XoopsFormText('Téléphone cellulaire :', 'telcell', 50, 255, $tel_cell));

    $sform->addElement(new XoopsFormText('Téléphone autre :', 'telother', 50, 255, $tel_other));

    $sform->addElement(new XoopsFormText("Entendu parler d'ODESIA ? :", 'heardodesia', 50, 255, $heard_odesia));

    $sform->addElement(new XoopsFormText('Personne ressource :', 'ressname', 50, 255, $rec_name . ' (' . $rec_email . ')'));

    $sform->addElement(new XoopsFormText('Email de la personne ressource :', 'ressemail', 50, 255, $rec_email));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'add', _MI_XENT_CR_SAVE, 'submit'));

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'EVSave'));

    $sform->display();

    CloseTable();
}

function EVDel($id_cv, $ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    $result = $xoopsDB->query('SELECT id, name, family_name, cv, rec_letter FROM ' . $xoopsDB->prefix('xent_cr_cv') . " WHERE id=$id_cv");

    [$id, $name, $family_name, $cv, $rec_letter] = $xoopsDB->fetchRow($result);

    if (1 == $ok) {
        unlink(XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . str_replace('%20', ' ', $cv));

        unlink(XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . str_replace('%20', ' ', $rec_letter));

        $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix('xent_cr_cv') . " WHERE id=$id_cv");

        redirect_header('admincv.php', 4, _AM_XENT_CR_DBUPDATED);

        exit();
    }  

    $myts = MyTextSanitizer::getInstance();

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
                                    <td class='bg1'>" . $rec_letter . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </form>
        ';

    echo "<table valign='top'><tr>";

    echo "<td width='30%'valign='top'><span style='color:#ff0000;'><b>" . _AM_XENT_CR_WANTDEL . '</b></span></td>';

    echo "<td width='3%'>\n";

    echo myTextForm("admincv.php?op=EVDel&id_cv=$id&ok=1", _AM_XENT_CR_YES);

    echo "</td><td>\n";

    echo myTextForm('admincv.php', _AM_XENT_CR_NO);

    echo "</td></tr></table>\n";

    CloseTable();
}

function EVSave($id_cv, $name, $family_name, $email, $address, $city, $province, $country, $zipcode, $telhome, $telcell, $telother, $heardodesia, $ressname, $ressemail)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('xent_cr_cv') . " SET id='$id_cv', name='$name', family_name='$family_name', email='$email', address='$address', city='$city', province='$province', country='$country', zipcode='$zipcode', tel_home='$telhome', tel_cell='$telcell', tel_other='$telother', heard_odesia='$heardodesia', rec_name='$ressname', rec_email='$rec_email' WHERE id=$id_cv");

    redirect_header("admincv.php?op=EVEdit&id_cv=$id_cv", 1, _AM_XENT_CR_DBUPDATED);

    exit();
}

function EVDisplay($id_cv)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xent_cr_cv') . " WHERE id=$id_cv");

    [$id, $name, $family_name, $email, $address, $city, $province, $country, $zipcode, $tel_home, $tel_cell, $tel_other, $cv, $rec_letter, $heard_odesia, $rec_name, $rec_email, $id_poste] = $xoopsDB->fetchRow($result);

    $poste = reference('xent_cr_job', 'id_titre', 'id_job', $id_poste);

    $poste = reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $poste);

    OpenTable();

    echo "
            <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
                <tr>
                    <td class='bg2'>
                        <table border='0' cellpadding='4' cellspacing='1' width='100%'>
                            <tr>
                                <td class='bg3' width='30%'><b>" . _AM_XENT_CR_NAME . "</b></td>
                                <td class='bg1'>" . $name . ' ' . $family_name . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_EMAIL . "</b></td>
                                <td class='bg1'>" . $email . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_ADDRESS . "</b></td>
                                <td class='bg1'>" . $address . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_CITY . "</b></td>
                                <td class='bg1'>" . $city . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_PROVINCE . "</b></td>
                                <td class='bg1'>" . $province . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_COUNTRY . "</b></td>
                                <td class='bg1'>" . $country . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_TELHOME . "</b></td>
                                <td class='bg1'>" . $tel_home . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_TELCELL . "</b></td>
                                <td class='bg1'>" . $tel_cell . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_TELOTHER . "</b></td>
                                <td class='bg1'>" . $tel_other . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_CV . "</b></td>
                                <td class='bg1'><a href=" . XOOPS_URL . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . str_replace(' ', '%20', $cv) . '>' . $cv . "</a></td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_LR . "</b></td>
                                <td class='bg1'><a href=" . XOOPS_URL . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . str_replace(' ', '%20', $rec_letter) . '>' . $rec_letter . "</a></td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_HEARDODESIA . "</b></td>
                                <td class='bg1'>" . $heard_odesia . "</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_RECNAME . "</b></td>
                                <td class='bg1'>" . $rec_name . ' (' . $rec_email . ")</td>
                            </tr>
                            <tr>
                                <td class='bg3'><b>" . _AM_XENT_CR_POSTE . "</b></td>
                                <td class='bg1'>" . $poste . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        ';

    CloseTable();
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'Admincv':
    Admincv($ordre);
    break;
    case 'EVEdit':
    EVEdit($id_cv);
    break;
    case 'EVDel':
    EVDel($id_cv, $ok);
    break;
    case 'EVDisplay':
    EVDisplay($id_cv);
    break;
    case 'EVSave':
    EVSave($id_cv, $name, $family_name, $email, $address, $city, $province, $country, $zipcode, $telhome, $telcell, $telother, $heardodesia, $ressname, $ressemail);
    break;
    default:
    $ordre = 'id_job';
    Admincv($ordre);
    break;
}
xoops_cp_footer();
