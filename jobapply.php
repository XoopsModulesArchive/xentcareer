<?php
include 'header.php';

$myts = MyTextSanitizer::getInstance();

if (empty($_POST['submit'])) {
    foreach ($_REQUEST as $a => $b) {
        $$a = $b;
    }

    if (empty($_POST['job_id'])) {
        $job_id = $_GET['job_id'];

        if (empty($_GET['nom'])) {
            $nom = '';
        }

        if (empty($_GET['prenom'])) {
            $prenom = '';
        }

        if (empty($_GET['email'])) {
            $email = '';
        }

        if (empty($_GET['address'])) {
            $address = '';
        }

        if (empty($_GET['ville'])) {
            $ville = '';
        }

        if (empty($_GET['zipcode'])) {
            $zipcode = '';
        }

        if (empty($_GET['telhome'])) {
            $telhome = '';
        }

        if (empty($_GET['telcell'])) {
            $telcell = '';
        }

        if (empty($_GET['telautre'])) {
            $telautre = '';
        }

        if (empty($_GET['heardodesia'])) {
            $heardodesia = '';
        }

        if (empty($_GET['nomress'])) {
            $nomress = '';
        }

        if (empty($_GET['emailress'])) {
            $emailress = '';
        }

        if (empty($_GET['cv'])) {
            $cv = '';
        }

        if (empty($_GET['rec'])) {
            $rec = '';
        }
    } else {
        $job_id = $_POST['job_id'];

        if (empty($_POST['nom'])) {
            $nom = '';
        }

        if (empty($_POST['prenom'])) {
            $prenom = '';
        }

        if (empty($_POST['email'])) {
            $email = '';
        }

        if (empty($_POST['address'])) {
            $address = '';
        }

        if (empty($_POST['ville'])) {
            $ville = '';
        }

        if (empty($_POST['zipcode'])) {
            $zipcode = '';
        }

        if (empty($_POST['telhome'])) {
            $telhome = '';
        }

        if (empty($_POST['telcell'])) {
            $telcell = '';
        }

        if (empty($_POST['telautre'])) {
            $telautre = '';
        }

        if (empty($_POST['heardodesia'])) {
            $heardodesia = '';
        }

        if (empty($_POST['nomress'])) {
            $nomress = '';
        }

        if (empty($_POST['emailress'])) {
            $emailress = '';
        }

        if (empty($_POST['cv'])) {
            $cv = '';
        }

        if (empty($_POST['rec'])) {
            $rec = '';
        }
    }

    $GLOBALS['xoopsOption']['template_main'] = 'xentcareer_jobform.html';

    require XOOPS_ROOT_PATH . '/header.php';

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    global $xoopsDB, $xoopsTpl, $xoopsModule, $xoopsModuleConfig, $xentLocations;

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status FROM ' . $xoopsDB->prefix('xent_cr_job') . " WHERE id_job=$job_id");

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id] = $xoopsDB->fetchRow($result);

    $titres = reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $titres_id);

    $typeposte = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'typeposte', 'id_typeposte', $typeposte_id);

    $loc = $xentLocations->getLocation($locations_id);

    $city = $loc['city'];

    $state = $loc['state'];

    $country = $loc['country'];

    $locations = $myts->displayTarea($city . ', ' . $state . ', ' . $country, 1, 0, 1, 0);

    //$locations = reference("xent_cr_locations", "locations", "id_locations", $locations_id);

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

    $postuler = new XoopsThemeForm(_MI_XENT_CR_FORMAPPLY, 'postuler', 'jobapply.php');

    $postuler->setExtra("enctype='multipart/form-data'"); //de xoops-doc

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'sendapply'));

    $postuler->addElement(new XoopsFormHidden('titres', $titres));

    $postuler->addElement(new xoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new xoopsFormText('* ' . _MI_XENT_CR_POSTPRENOM, 'prenom', 40, 255, $prenom), true);

    $postuler->addElement(new xoopsFormText('* ' . _MI_XENT_CR_POSTNOM, 'nom', 40, 255, $nom), true);

    $postuler->addElement(new xoopsFormText('* ' . _MI_XENT_CR_EMAIL, 'email', 40, 255, $email), true);

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_ADDRESS, 'address', 40, 255, $address));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_VILLE, 'ville', 40, 255, $ville));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_PROVINCE, 'province', 40, 255, 'Quebec'));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_PAYS, 'pays', 40, 255, 'Canada'));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_ZIPCODE, 'zipcode', 10, 7, $zipcode));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_TELHOME, 'telhome', 16, 21, $telhome));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_TELCELL, 'telcell', 16, 21, $telcell));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_TELAUTRE, 'telautre', 16, 21, $telautre));

    $postuler->addElement(new xoopsFormLabel('<br><hr><br>', '<br><hr><br>'));

    $cv_box = new XoopsFormFile('* ' . _MI_XENT_CR_CVFULL, 'cv', $xoopsModuleConfig['maxfilesize']);

    $postuler->addElement($cv_box, true);

    $postuler->addElement(new xoopsFormLabel('<br>', '<br>'));

    #$rec_box = new XoopsFormFile(_MI_XENT_CR_RECFULL, "rec", 50000);

    #$postuler->addElement($rec_box, false);

    $postuler->addElement(new xoopsFormLabel('<br><hr><br>', '<br><hr><br>'));

    $thearray = GetTopic('xent_cr_reference', 'reference_job', 'id');

    $object = new xoopsFormSelect(_MI_XENT_CR_WHEREODESIA, 'heardodesia', $heardodesia, 1, false);

    $object->addOptionArray($thearray);

    $postuler->addElement($object);

    $postuler->addElement(new xoopsFormLabel('<br><hr>', '<br><hr>'));

    $postuler->addElement(new xoopsFormLabel('', _MI_XENT_CR_RECOMMANDFULL));

    $postuler->addElement(new xoopsFormLabel('<br>', '<br>'));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_POSTNOMPRENOM, 'nomress', 40, 255, $nomress));

    $postuler->addElement(new xoopsFormText(_MI_XENT_CR_EMAIL, 'emailress', 40, 255, $emailress));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'submit', _MI_XENT_CR_POSTULER, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    include 'footer.php';
} else {
    require_once XOOPS_ROOT_PATH . '/class/uploader.php';

    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    if (empty($_POST['nom'])) {
        $nom = '';
    }

    if (empty($_POST['prenom'])) {
        $prenom = '';
    }

    if (empty($_POST['email'])) {
        $email = '';
    }

    if (empty($_POST['address'])) {
        $address = '';
    }

    if (empty($_POST['ville'])) {
        $ville = '';
    }

    if (empty($_POST['zipcode'])) {
        $zipcod = '';
    }

    if (empty($_POST['telhome'])) {
        $telhome = '';
    }

    if (empty($_POST['telcell'])) {
        $telcell = '';
    }

    if (empty($_POST['telautre'])) {
        $telautre = '';
    }

    if (empty($_POST['heardodesia'])) {
        $heardodesia = '';
    }

    if (empty($_POST['nomress'])) {
        $nomress = '';
    }

    if (empty($_POST['emailress'])) {
        $emailress = '';
    }

    if (empty($_POST['cv'])) {
        $cv = '';
    }

    if (empty($_POST['rec'])) {
        $rec = '';
    }

    //$xoopsModuleConfig['sbuploaddir']

    extract($_POST);

    $myts = MyTextSanitizer::getInstance();

    $job_id = $myts->stripSlashesGPC($job_id);

    $prenom = $myts->stripSlashesGPC($prenom);

    $nom = $myts->stripSlashesGPC($nom);

    $email = $myts->stripSlashesGPC($email);

    $address = $myts->stripSlashesGPC($address);

    $ville = $myts->stripSlashesGPC($ville);

    $province = $myts->stripSlashesGPC($province);

    $pays = $myts->stripSlashesGPC($pays);

    $zipcode = $myts->stripSlashesGPC($zipcode);

    $telcell = $myts->stripSlashesGPC($telcell);

    $telhome = $myts->stripSlashesGPC($telhome);

    $telautre = $myts->stripSlashesGPC($telautre);

    $titres = $myts->stripSlashesGPC($titres);

    $Name = "$prenom $nom";

    $cv = $cv;

    $cvname = mb_strrchr($cv, '\\');

    $cvname = str_replace('\\', '/', $cvname);

    //pour l'uploader sur le serveur
    $max_imgsize = $xoopsModuleConfig['maxfilesize']; // ou = $xoopsModuleConfig[max_imgsize]
    $allowed_mimetypes = explode(';', $xoopsModuleConfig['cv_extention']);

    $cv_dir = XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv']; // ou = XOOPS_UPLOAD_PATH; (répertoire upload de xoops)

    $uploader = new XoopsMediaUploader($cv_dir, $allowed_mimetypes, $max_imgsize, null, null);

    $mydate = date('Ymd_His');

    $url_cv_long = '';

    $url_rec_long = '';

    $url_cv_short = '';

    $url_rec_short = '';

    $field = $_POST['xoops_upload_file'][0];

    #$field1 = $_POST["xoops_upload_file"][1] ;

    #$lr_nothing = 1;

    if (!empty($field) || '' != $field) {
        if (('' == $_FILES[$field]['tmp_name'] || !is_readable($_FILES[$field]['tmp_name']))) {
            redirect_header("jobapply.php?job_id=$job_id&prenom=$prenom&nom=$nom&email=$email&address=$address&ville=$ville&zipcode=$zipcode&telcell=$telcell&telhome=$telhome&telautre=$telautre&heardodesia=$heardodesia&nomress=$nomress&emailress=$emailress", 4, sprintf(_MI_XENT_CR_SENDDOCTYPEERROR, $xoopsModuleConfig['cv_extention'], $xoopsModuleConfig['maxfilesize']) . '<br>CV');

            //redirect_header( "jobapply.php?job_id=$job_id" , 4, _MI_XENT_CR_SENDDOCTYPEERROR." CV" ) ;

            exit;
        }

        $cvok = 1;
    }

    /*if ($HTTP_POST_FILES['rec']['name'] != "") {
        if( !empty( $field1 ) || $field1 != "" ) {

            if( $_FILES[$field1]['tmp_name'] == "" || ! is_readable( $_FILES[$field1]['tmp_name'] ) ) {

                redirect_header( "jobapply.php?job_id=$job_id&prenom=$prenom&nom=$nom&email=$email&address=$address&ville=$ville&zipcode=$zipcode&telcell=$telcell&telhome=$telhome&telautre=$telautre&heardodesia=$heardodesia&nomress=$nomress&emailress=$emailress" , 4, sprintf(_MI_XENT_CR_SENDDOCTYPEERROR, $xoopsModuleConfig['cv_extention'], $xoopsModuleConfig['maxfilesize'])."<br>LR" ) ;
                //redirect_header( "jobapply.php?job_id=$job_id" , 4, _MI_XENT_CR_SENDDOCTYPEERROR." LR" ) ;
                exit ;
            }

            $lrok = 1;
            $lr_nothing=1;

        }
    }else {
        $lr_nothing = 0;
        $lrok = 1;
    }*/

    #if ($cvok == 1 && $lrok ==1){

    if (1 == $cvok) {
        if ($uploader->fetchMedia($field) && $uploader->upload($field)) {
            $oldfileCV = XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . mb_strtolower($HTTP_POST_FILES['cv']['name']);

            $newfileCV = XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv'] . '/CV_' . $mydate . '_' . mb_strtolower($HTTP_POST_FILES['cv']['name']);

            $url_cv_short = 'CV_' . $mydate . '_' . mb_strtolower($HTTP_POST_FILES['cv']['name']);

            //$newfileCV = str_replace(' ', '%20', $newfileCV);

            rename($oldfileCV, $newfileCV);

            chmod($newfileCV, 0755);

            $msgformupdate = 'File uploaded successfully!';

            $url_cv_long = XOOPS_URL . $xoopsModuleConfig['sbuploaddir_cv'] . '/CV_' . $mydate . '_' . mb_strtolower($HTTP_POST_FILES['cv']['name']);

            $url_cv_long = str_replace(' ', '%20', $url_cv_long);
        } else {
            $msgformupdate = $uploader->getErrors();
        }

        /*if ($lr_nothing == 1){

            if( $uploader->fetchMedia($field1 ) && $uploader->upload($field1) ) {

                $oldfileLR = XOOPS_ROOT_PATH.$xoopsModuleConfig['sbuploaddir_cv']."/".strtolower($HTTP_POST_FILES['rec']['name']);
                $newfileLR = XOOPS_ROOT_PATH.$xoopsModuleConfig['sbuploaddir_cv']."/LR_".$mydate."_".strtolower($HTTP_POST_FILES['rec']['name']);
                $url_rec_short = "LR_".$mydate."_".strtolower($HTTP_POST_FILES['rec']['name']);

                //$newfileLR = str_replace(' ', '%20', $newfileLR);

                rename( $oldfileLR, $newfileLR );
                chmod( $newfileLR, 0755);
                $msgformupdate .= "File uploaded successfully!";

                $url_rec_long = XOOPS_URL.$xoopsModuleConfig['sbuploaddir_cv']."/LR_".$mydate."_".strtolower($HTTP_POST_FILES['rec']['name']);
                $url_rec_long = str_replace(' ', '%20', $url_rec_long);
            } else {
                $msgformupdate .= $uploader->getErrors();
            }
        }*/
    }

    //fin de uploader pour le serveur

    if (1 == $xoopsModuleConfig['sendbymail']) {
        $CandidatureMessage = '' . _MI_XENT_CR_SUBMITTED . " $Name\n";

        $CandidatureMessage .= '' . _MI_XENT_CR_EMAIL . " $email\n";

        $CandidatureMessage .= "\n";

        $CandidatureMessage .= sprintf(_MI_XENT_CR_INFOPOST, $titres, $job_id) . "\n";

        $CandidatureMessage .= "\n";

        $CandidatureMessage .= _MI_XENT_CR_POSTLINK . "\n";

        $CandidatureMessage .= XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/viewjob.php?op=XENT_CR_FullviewByID&job_id=$job_id\n";

        $CandidatureMessage .= "\n";

        $CandidatureMessage .= _MI_XENT_CR_POSTINFORMATION . "\n";

        if (!empty($prenom) && !empty($nom)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_NOM . ":       $prenom $nom\n";
        }

        if (!empty($email)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_EMAIL . "    $email\n";
        }

        if (!empty($address)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_ADDRESS . "  $address\n";
        }

        if (!empty($ville)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_VILLE . "    $ville\n";
        }

        if (!empty($pays)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_PROVINCE . " $province\n";
        }

        if (!empty($pays)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_PAYS . "     $pays\n";
        }

        if (!empty($zipcode)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_ZIPCODE . " $zipcode\n";
        }

        if (!empty($telcell)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_TELCELL . "  $telcell\n";
        }

        if (!empty($telhome)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_TELHOME . " $telhome\n";
        }

        if (!empty($telautre)) {
            $CandidatureMessage .= "\t" . _MI_XENT_CR_TELAUTRE . "       $telautre\n";
        }

        $CandidatureMessage .= "\n" . _MI_XENT_CR_POSTINFORMATIONPLUS . "\n";

        $CandidatureMessage .= "\t" . _MI_XENT_CR_CVSHORT . $url_cv_long . "\n";

        $CandidatureMessage .= "\t" . _MI_XENT_CR_RECSHORT . $url_rec_long . "\n";

        $CandidatureMessage .= "\t" . _MI_XENT_CR_WHEREODESIA;

        $CandidatureMessage .= "\t" . $myts->displayTarea(reference('xent_cr_reference', 'reference_job', 'id', $heardodesia)) . "\n";

        $CandidatureMessage .= "\t" . _MI_XENT_CR_RECOMMANDSHORT;

        $CandidatureMessage .= "\t" . $nomress . ' (' . $emailress . ')';

        $subject = $xoopsConfig['sitename'] . ' - ' . _MI_XENT_CR_APPLYFORM . $titres;

        $xoopsMailer = getMailer();

        $xoopsMailer->useMail();

        $xoopsMailer->setToEmails($xoopsModuleConfig['emailrh']);

        $xoopsMailer->setFromEmail($email);

        $xoopsMailer->setFromName($xoopsConfig['sitename']);

        $xoopsMailer->setSubject($subject);

        $xoopsMailer->setBody($CandidatureMessage);

        $xoopsMailer->send();

        $messagesent = _MI_XENT_CR_MESSAGESENT . '<br>' . _MI_XENT_CR_MESSAGESENT2 . '<br><br>' . _MI_XENT_CR_THANKYOU . '';

        // uncomment the following lines if you want to send confirmation mail to the user

        $CandidatConfirmMessage = sprintf(_MI_XENT_CR_CONFIRMHELLO, $Name);

        $CandidatConfirmMessage .= "\n\n";

        $CandidatConfirmMessage .= sprintf(_MI_XENT_CR_THANKYOUDEMANDE, $titres);

        //$CandidatureMessage .= _MI_XENT_CR_CONFIRMPOSTLINK."\n";

        //$CandidatureMessage .= XOOPS_URL. "/modules/". $xoopsModule->getVar('dirname')."/viewjob.php?op=XENT_CR_FullviewByID&job_id=$job_id\n";

        $CandidatConfirmMessage .= "\n\n";

        $CandidatConfirmMessage .= _MI_XENT_CR_CONFIRMMSGINFO;

        $CandidatConfirmMessage .= "\n";

        if (!empty($prenom) && !empty($nom)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_NOM . ":       $prenom $nom\n";
        }

        if (!empty($email)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_EMAIL . "    $email\n";
        }

        if (!empty($address)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_ADDRESS . "  $address\n";
        }

        if (!empty($ville)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_VILLE . "    $ville\n";
        }

        if (!empty($pays)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_PROVINCE . " $province\n";
        }

        if (!empty($pays)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_PAYS . "     $pays\n";
        }

        if (!empty($zipcode)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_ZIPCODE . " $zipcode\n";
        }

        if (!empty($telcell)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_TELCELL . "  $telcell\n";
        }

        if (!empty($telhome)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_TELHOME . " $telhome\n";
        }

        if (!empty($telautre)) {
            $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_TELAUTRE . "       $telautre\n";
        }

        $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_CVSHORT . $HTTP_POST_FILES['cv']['name'] . "\n";

        #$CandidatConfirmMessage .= "\t"._MI_XENT_CR_RECSHORT.$HTTP_POST_FILES['rec']['name']."\n";

        $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_WHEREODESIA;

        $CandidatConfirmMessage .= "\t" . $myts->displayTarea(reference('xent_cr_reference', 'reference_job', 'id', $heardodesia)) . "\n";

        $CandidatConfirmMessage .= "\t" . _MI_XENT_CR_RECOMMANDSHORT;

        $CandidatConfirmMessage .= "\t" . $nomress . ' (' . $emailress . ')';

        $CandidatConfirmMessage .= "\n\n";

        $CandidatConfirmMessage .= _MI_XENT_CR_RHTANK;

        $CandidatConfirmMessage .= "\n";

        $CandidatConfirmMessage .= $myts->displayTarea($xoopsModuleConfig['departementname']);

        $CandidatConfirmMessage .= "\n";

        $CandidatConfirmMessage .= $xoopsModuleConfig['emailrh'];

        $CandidatConfirmMessage .= "\n";

        $CandidatConfirmMessage .= XOOPS_URL;

        if (!empty($xoopsModuleConfig['xent_cr_cie'])) {
            $confirm_subject = sprintf($xoopsModuleConfig['xent_cr_cie'] . ' - ' . _MI_XENT_CR_CONFIRMTHANKYOU, $titres);
        } else {
            $confirm_subject = sprintf(_MI_XENT_CR_CONFIRMTHANKYOU, $titres);
        }

        $xoopsMailer = getMailer();

        $xoopsMailer->useMail();

        $xoopsMailer->setToEmails($email);

        $xoopsMailer->setFromEmail($xoopsModuleConfig['emailrh']);

        $xoopsMailer->setFromName($xoopsConfig['sitename']);

        $xoopsMailer->setSubject($confirm_subject);

        $xoopsMailer->setBody($CandidatConfirmMessage);

        $xoopsMailer->send();
    }

    //requêtre SQL pour domper les trucs dans la bd

    //$query = "INSERT INTO ".$xoopsDB->prefix("xent_cr_cv")." VALUES('$prenom','$nom','$email','$address', '$ville', '$province', '$pays', '$zipcode', '$telhome', '$telcell', '$telautre', '$HTTP_POST_FILES['cv']['name']','$HTTP_POST_FILES['rec']['name']', '$heardodesia', '$nomress', '$emailress'";

    //$query = "INSERT INTO ".$xoopsDB->prefix("xent_cr_cv")." VALUES('$prenom', '$nom','$email','$address', '$ville', '$province', '$pays', '$zipcode', '$telhome', '$telcell', '$telautre', '$url_cv_short', '$url_rec_short', '$heardodesia', '$nomress', '$emailress')";

    //$real_query = "INSERT INTO xoops_xent_cr_cv (name, family_name, email, address, city, province, country, zipcode, telhome, telcell, telother, cv, rec_letter, heardodesia, rec_name, rec_email) VALUES('alex', 'parent','aparent@odesia.com','', '', 'Quebec', 'Canada', '', '', '', '', 'CV_20040922_150747_bi market.doc', '', '------------------------', '', '')";

    $real_query = sprintf("INSERT INTO %s (name, family_name, email, address, city, province, country, zipcode, tel_home, tel_cell, tel_other, cv, rec_letter, heard_odesia, rec_name, rec_email, id_poste) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %u)", $xoopsDB->prefix($module_tables[3]), $prenom, $nom, $email, $address, $ville, $province, $pays, $zipcode, $telhome, $telcell, $telautre, $url_cv_short, $url_rec_short, $heardodesia, $nomress, $emailress, $job_id);

    //$sql = "INSERT INTO %s (name, family_name, email, address, city, province, country, zipcode, tel_home, tel_cell, tel_other, cv, rec_letter, heard_odesia, rec_name, rec_email, id_poste) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%u')".$xoopsDB->prefix($module_tables[3])." $prenom, $nom, $email, $address, $ville, $province, $pays, $zipcode, $telhome, $telcell, $telautre, $url_cv_short, $url_rec_short, $heardodesia, $nomress, $emailress, $job_id";

    //$real_query = sprintf($sql);

    $result = $xoopsDB->query($real_query);

    redirect_header("viewjob.php?op=XENT_CR_FullviewByID&job_id=$job_id", 7, $messagesent . "\n" . $msgformupdate);
}
