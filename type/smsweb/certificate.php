<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from view.php
}

require_once("$CFG->libdir/grouplib.php");

$key = 'R@ch31r@y!';
// $baseurl = 'http://develsmsweb.teex.tamus.edu/OnlinePrintCertificate.aspx';
 $baseurl = 'https://testsmsweb.teex.tamus.edu/OnlinePrintCertificate.aspx';
// $baseurl = 'https://smsweb.teex.tamus.edu/OnlinePrintCertificate.aspx';

$group = get_group($course->id, $USER->id);
$time = time();
// $pk = strtoupper(hash_hmac('sha256',$USER->idnumber . $time, $key));
$params = array(
                  'R'  => 'TeexLMS',
                  'D'  => substr($course->idnumber, 0, 2),
                  'V'  => $USER->idnumber,
                  'C'  => substr($course->idnumber, 2),
                  'S'  => $group,
                  'T' => $time
                  );


$params_http = http_build_query($params, '', '&');
$params_html = http_build_query($params, '', '&amp;');

$pk = strtoupper(hash_hmac('sha256','?' . $params_http, $key));
$redirecturl = "$baseurl?$params_http&PK=$pk";
$certhtml = <<<HERE
<html><body><a href="$baseurl?$params_html&amp;PK=$pk">Continue</a></body></html>
HERE;

function get_group($courseid, $userid) {
    global $DB;
    $groups = groups_get_user_groups($courseid, $userid);
    $group = $DB->get_record('groups', array('id' => $groups[0][0]));
    return $group->name;
}
?>
