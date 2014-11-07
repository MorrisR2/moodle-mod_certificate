<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from view.php
}

require_once("$CFG->libdir/grouplib.php");

$key = 'R@ch31r@y!';
// $baseurl = 'http://develsmsweb.teex.tamus.edu/OnlinePrintCertificate.aspx';
 $baseurl = 'https://testsmsweb.teex.tamus.edu/OnlinePrintCertificate.aspx';
// $baseurl = 'https://smsweb.teex.tamus.edu/OnlinePrintCertificate.aspx';

// Disable the button for 4 seconds after clicking, to avoid clicking twice
$PAGE->requires->js("/mod/certificate/type/smsweb/nodblclick.js");
class nodoubleclick_action extends component_action {
     public function __construct($event, $callback = null) {
         parent::__construct('click', 'noDblClick', array());
    }
}

$group = get_group($course->id, $USER->id);
$time = time();

preg_match('/^(..)([^\-]*)-?(.*)$/', $course->idnumber, $parts);
list ($div, $coursenumber, $extra) = array ($parts[1], $parts[2], $parts[3]);
$params = array(
                  'R'  => 'TeexLMS',
                  'D'  => $div,
                  'V'  => $USER->idnumber,
                  'C'  => $coursenumber,
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
