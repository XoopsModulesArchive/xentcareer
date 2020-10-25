<?php
include 'header.php';

if (empty($_POST['job_id'])) {
    $job_id = $_GET['job_id'];
} else {
    $job_id = $_POST['job_id'];
}

$myts = MyTextSanitizer::getInstance();

if (empty($_POST['submit'])) {
    $GLOBALS['xoopsOption']['template_main'] = 'xentcareer_sendfriend.html';

    require XOOPS_ROOT_PATH . '/header.php';

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    global $xoopsDB, $xoopsTpl;

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status FROM ' . $xoopsDB->prefix('xent_cr_job') . " WHERE id_job=$job_id");

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id] = $xoopsDB->fetchRow($result);

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

    $xoopsTpl->assign('lang_VIEWID', _MI_XENT_CR_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_XENT_CR_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_XENT_CR_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_XENT_CR_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWSTATUS', _MI_XENT_CR_VIEWSTATUS);

    $xoopsTpl->assign('lang_VIEWSTARTDDATE', _MI_XENT_CR_VIEWSTARTDDATE);

    $xoopsTpl->assign('lang_VIEWENDDATE', _MI_XENT_CR_VIEWENDDATE);

    $xoopsTpl->assign('xent_cr_job_id', $job_id);

    $xoopsTpl->assign('xent_cr_jobposteddate', $jobposteddate);

    $xoopsTpl->assign('xent_cr_titres', $titres);

    $xoopsTpl->assign('xent_cr_typeposte', $typeposte);

    $xoopsTpl->assign('xent_cr_locations', $locations);

    $xoopsTpl->assign('xent_cr_status', $status);

    $xoopsTpl->assign('xent_cr_jobstartdate', $jobstartdate);

    $xoopsTpl->assign('xent_cr_jobenddate', $jobenddate);

    $postuler = new XoopsThemeForm(_MI_XENT_CR_FORMAPPLY, 'postuler', 'sendfriend.php');

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'sendapply'));

    $postuler->addElement(new XoopsFormHidden('titres', $titres));

    $postuler->addElement(new xoopsFormLabel('<b><u>' . _MI_XENT_CR_POSTENVOYEUR . '</u></b>', ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_POSTNOMPRENOM, 'envoyeur', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br><br>', ''));

    $postuler->addElement(new xoopsFormLabel('<b><u>' . _MI_XENT_CR_DESTINATAIRES . '</b></u>', ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_POSTNOMPRENOM, 'prenomnom1', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_EMAIL, 'email1', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_POSTNOMPRENOM, 'prenomnom2', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_EMAIL, 'email2', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_POSTNOMPRENOM, 'prenomnom3', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_EMAIL, 'email3', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormTextArea(_MI_XENT_CR_COMMENT, 'comment'));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'submit', _MI_XENT_CR_SENDTOFRIEND, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    include 'footer.php';
} else {
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    //$xoopsModuleConfig['sbuploaddir']

    extract($_POST);

    $myts = MyTextSanitizer::getInstance();

    $job_id = $myts->stripSlashesGPC($job_id);

    $email = $myts->stripSlashesGPC($email1);

    $CandidatureMessage = $envoyeur;

    $CandidatureMessage .= _MI_XENT_CR_SENDFRIENDBODYRH;

    $CandidatureMessage .= "\n\n\t";

    $CandidatureMessage .= $titres;

    $CandidatureMessage .= "\n\n\t";

    if (!empty($prenomnom1) && !empty($email1)) {
        $CandidatureMessage .= $prenomnom1 . '(' . $email1 . ")\n\t";
    }

    if (!empty($prenomnom2) && !empty($email2)) {
        $CandidatureMessage .= $prenomnom2 . '(' . $email2 . ")\n\t";
    }

    if (!empty($prenomnom3) && !empty($email3)) {
        $CandidatureMessage .= $prenomnom3 . '(' . $email3 . ")\n\t";
    }

    $subject = $xoopsConfig['sitename'] . ' - ' . _MI_XENT_CR_SENDFRIENDRHCONF . _MI_XENT_CR_POSTE . $titres;

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($xoopsModuleConfig['emailrh']);

    $xoopsMailer->setFromEmail($xoopsModuleConfig['emailrh']);

    $xoopsMailer->setFromName($xoopsConfig['sitename']);

    $xoopsMailer->setSubject($subject);

    $xoopsMailer->setBody($CandidatureMessage);

    $xoopsMailer->send();

    $messagesent = _MI_XENT_CR_MESSAGESENT . '<br>' . _MI_XENT_CR_MESSAGESENT2 . '<br><br>' . _MI_XENT_CR_THANKYOU . '';

    //envoie de 1 à 3 email au(x) ami(s)

    for ($x = 1; $x <= 5; $x++) {
        $confirm_subject = sprintf($envoyeur . _MI_XENT_CR_SENDFRIENDSUBJET . $titres);

        $xoopsMailer = getMailer();

        $xoopsMailer->useMail();

        $xoopsMailer->setFromEmail($xoopsModuleConfig['emailrh']);

        $xoopsMailer->setFromName($xoopsConfig['sitename']);

        $xoopsMailer->setSubject($confirm_subject);

        $canSend = false;

        switch ($x) {
            case 1:
            if (!empty($prenomnom1) && !empty($email1)) {
                $CandidatConfirmMessage = sprintf(_MI_XENT_CR_CONFIRMHELLO, $prenomnom1);

                $xoopsMailer->setToEmails($email1);

                $canSend = true;
            }
            break;
            case 2:
            if (!empty($prenomnom2) && !empty($email2)) {
                $CandidatConfirmMessage = sprintf(_MI_XENT_CR_CONFIRMHELLO, $prenomnom2);

                $xoopsMailer->setToEmails($email2);

                $canSend = true;
            }
            break;
            case 3:
            if (!empty($prenomnom3) && !empty($email3)) {
                $CandidatConfirmMessage = sprintf(_MI_XENT_CR_CONFIRMHELLO, $prenomnom3);

                $xoopsMailer->setToEmails($email3);

                $canSend = true;
            }
            break;
        }

        if (true === $canSend) {
            $CandidatConfirmMessage .= "\n\n";

            $CandidatConfirmMessage .= $envoyeur;

            $CandidatConfirmMessage .= sprintf(_MI_XENT_CR_SENDFRIENDBODY);

            $CandidatConfirmMessage .= sprintf(_MI_XENT_CR_COMPAGNIE);

            $CandidatConfirmMessage .= $xoopsConfig['sitename'];

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= sprintf(_MI_XENT_CR_POSTE);

            $CandidatConfirmMessage .= $titres;

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= sprintf(_MI_XENT_CR_COMMENT);

            $CandidatConfirmMessage .= $comment;

            $CandidatConfirmMessage .= "\n\n";

            $CandidatConfirmMessage .= sprintf(_MI_XENT_CR_LIEN);

            $CandidatConfirmMessage .= XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/viewjob.php?op=XENT_CR_FullviewByID&job_id=$job_id";

            $CandidatConfirmMessage .= "\n\n";

            $CandidatConfirmMessage .= _MI_XENT_CR_RHTANK;

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= $myts->displayTarea($xoopsModuleConfig['departementname']);

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= $xoopsModuleConfig['emailrh'];

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= XOOPS_URL;

            $xoopsMailer->setBody($CandidatConfirmMessage);

            $xoopsMailer->send();
        }
    }

    //$messagesent .= sprintf(_MI_XENT_CR_SENTASCONFIRM,$usersEmail);

    redirect_header("viewjob.php?op=XENT_CR_FullviewByID&job_id=$job_id", 10, $messagesent);
}
