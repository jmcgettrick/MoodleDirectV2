<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

require_once(__DIR__."/../../config.php");
require_once(__DIR__."/lib.php");
require_once($CFG->dirroot.'/mod/turnitintooltwo/turnitintooltwo_assignment.class.php');
require_once($CFG->dirroot.'/mod/turnitintooltwo/turnitintooltwo_view.class.php');

require_login();

$action = required_param('action', PARAM_ALPHAEXT);
$cmid = optional_param('cmid', 0, PARAM_INT);
$itemid = optional_param('itemid', 0, PARAM_INT);
if( !empty( $cmid ) ){
    $cm = get_coursemodule_from_id('', $cmid);
    $context = context_course::instance($cm->course);
}
$pathnamehash = optional_param('pathnamehash', "", PARAM_ALPHANUM);
$submissiontype = optional_param('submission_type', "", PARAM_ALPHAEXT);
$return = array();

// Initialise plugin class.
$pluginturnitin = new plagiarism_plugin_turnitin();

switch ($action) {
    case "process_submission":
        if (!confirm_sesskey()) {
            throw new moodle_exception('invalidsesskey', 'error');
        }

        $cansubmit = ($cm->modname == "forum") ? has_capability('mod/'.$cm->modname.':replypost', $context) :
                                            (has_capability('mod/'.$cm->modname.':submit', $context) ||
                                                    has_capability('mod/'.$cm->modname.':grade', $context));

        $textcontent = ($cm->modname == "forum") ? optional_param('textcontent', "", PARAM_ALPHAEXT) : '';

        if ($cansubmit) {
            // Create the course/class in Turnitin if it doesn't already exist.
            $coursedata = turnitintooltwo_assignment::get_course_data($cm->course, 'PP');

            if (empty($coursedata->turnitin_cid)) {
                // Course may existed in a previous incarnation of this plugin so the Turnitin id may be located
                // in the config table. Get this and save it in courses table if so.
                if ($turnitincid = $pluginturnitin->get_previous_course_id($cm)) {
                    $coursedata = $pluginturnitin->migrate_previous_course($coursedata, $turnitincid);
                } else {
                    $tiicoursedata = $pluginturnitin->create_tii_course($cm, $coursedata);
                    $coursedata->turnitin_cid = $tiicoursedata->turnitin_cid;
                    $coursedata->turnitin_ctl = $tiicoursedata->turnitin_ctl;
                }
            }

            // Check whether the file needs to be submitted to Turnitin.
            if ($pluginturnitin->check_if_submitting($cm, $USER->id, $pathnamehash, $submissiontype)
                                        && $coursedata->turnitin_cid != 0) {
                // Create/Edit user within Turnitin and join the user to the course/class if necessary.
                $user = new turnitintooltwo_user($USER->id, 'Learner');
                $user->join_user_to_class($coursedata->turnitin_cid);

                // Create/Edit the module as an assignment in Turnitin.
                $assignmentid = $pluginturnitin->sync_tii_assignment($cm, $coursedata->turnitin_cid);

                $title = '';
                if ($cm->modname == "forum") {
                    $moduledata = $DB->get_record($cm->modname, array('id' => $cm->instance));
                    $title = 'forumpost_'.$user->id."_".$cm->id."_".$moduledata->id."_".$itemid.'.txt';
                }

                // Submit or resubmit file to Turnitin.
                $return = $pluginturnitin->tii_submission($cm, $assignmentid, $user, $pathnamehash, $submissiontype,
                                                            $itemid, $title, $textcontent);

            } else {
                $return = array("success" => true);
            }
        }
        break;

    case "origreport":
    case "grademark":
        $submissionid = optional_param('submission', 0, PARAM_INT);

        switch ($cm->modname) {
            case "forum":
            case "workshop":
                $istutor = has_capability('plagiarism/turnitin:viewfullreport', $context);
                break;
            default:
                $istutor = has_capability('mod/'.$cm->modname.':grade', $context);
                break;
        }

        $isstudent = ($cm->modname == "forum") ? has_capability('mod/'.$cm->modname.':replypost', $context) :
                                                has_capability('mod/'.$cm->modname.':submit', $context);

        if ($istutor || $isstudent) {
            $role = ($istutor) ? "Instructor" : "Learner";
            $user = new turnitintooltwo_user($USER->id, $role);
            $coursedata = turnitintooltwo_assignment::get_course_data($cm->course, 'PP');

            $user->join_user_to_class($coursedata->turnitin_cid);

            echo turnitintooltwo_view::output_dv_launch_form($action, $submissionid, $user->tii_user_id, $role);
        }
        break;

    case "update_grade":
        if (!confirm_sesskey()) {
            throw new moodle_exception('invalidsesskey', 'error');
        }

        include_once($CFG->libdir."/gradelib.php");

        $submissionid = optional_param('submission', 0, PARAM_INT);

        // Get moodle user id of submission.
        $return["status"] = $pluginturnitin->update_grade_from_tii($cm, $submissionid);
        break;

    case "refresh_peermark_assignments":
        if (!confirm_sesskey()) {
            throw new moodle_exception('invalidsesskey', 'error');
        }

        $tiiassignment = $DB->get_record('plagiarism_turnitin_config', array('cm' => $cm->id, 'name' => 'turnitin_assignid'));
        $pluginturnitin->refresh_peermark_assignments($cm, $tiiassignment->value);
        break;

    case "peermarkmanager":
        switch ($cm->modname) {
            case "forum":
            case "workshop":
                $istutor = has_capability('plagiarism/turnitin:viewfullreport', $context);
                break;
            default:
                $istutor = has_capability('mod/'.$cm->modname.':grade', $context);
                break;
        }

        if ($istutor) {
            // Create the course/class in Turnitin if it doesn't already exist.
            $coursedata = turnitintooltwo_assignment::get_course_data($cm->course, 'PP');

            $tiiassignment = $DB->get_record('plagiarism_turnitin_config', array('cm' => $cm->id, 'name' => 'turnitin_assignid'));

            if (!$tiiassignment) {
                if (empty($coursedata->turnitin_cid)) {
                    // Course may existed in a previous incarnation of this plugin so the Turnitin id may be located
                    // in the config table. Get this and save it in courses table if so.
                    if ($turnitincid = $pluginturnitin->get_previous_course_id($cm)) {
                        $coursedata = $pluginturnitin->migrate_previous_course($coursedata, $turnitincid);
                    } else {
                        $tiicoursedata = $pluginturnitin->create_tii_course($cm, $coursedata);
                        $coursedata->turnitin_cid = $tiicoursedata->turnitin_cid;
                        $coursedata->turnitin_ctl = $tiicoursedata->turnitin_ctl;
                    }
                }

                // Create the module as an assignment in Turnitin.
                $tiiassignment->value = $pluginturnitin->sync_tii_assignment($cm, $coursedata->turnitin_cid);
            }

            $user = new turnitintooltwo_user($USER->id, "Instructor");
            $user->join_user_to_class($coursedata->turnitin_cid);

            echo html_writer::tag("div", turnitintooltwo_view::output_lti_form_launch('peermark_manager',
                                                        'Instructor', $tiiassignment->value),
                                                        array("class" => "launch_form", "style" => "display:none;"));
            echo html_writer::script("<!--
                                    window.document.forms[0].submit();
                                    //-->");
        }
        break;

    case "rubricview":
        $isstudent = ($cm->modname == "forum") ? has_capability('mod/'.$cm->modname.':replypost', $context) :
                                                has_capability('mod/'.$cm->modname.':submit', $context);
        if ($isstudent) {
            $tiiassignment = $DB->get_record('plagiarism_turnitin_config', array('cm' => $cm->id, 'name' => 'turnitin_assignid'));

            $user = new turnitintooltwo_user($USER->id, "Learner");
            $coursedata = turnitintooltwo_assignment::get_course_data($cm->course, 'PP');
            $user->join_user_to_class($coursedata->turnitin_cid);

            echo html_writer::tag("div", turnitintooltwo_view::output_lti_form_launch('rubric_view',
                                                        'Learner', $tiiassignment->value),
                                                        array("class" => "launch_form", "style" => "display:none;"));
            echo html_writer::script("<!--
                                    window.document.forms[0].submit();
                                    //-->");
        }
        break;

    case "peermarkreviews":
        switch ($cm->modname) {
            case "forum":
            case "workshop":
                $istutor = has_capability('plagiarism/turnitin:viewfullreport', $context);
                break;
            default:
                $istutor = has_capability('mod/'.$cm->modname.':grade', $context);
                break;
        }

        $isstudent = ($cm->modname == "forum") ? has_capability('mod/'.$cm->modname.':replypost', $context) :
                                                has_capability('mod/'.$cm->modname.':submit', $context);

        if ($istutor || $isstudent) {
            $role = ($istutor) ? 'Instructor' : 'Learner';

            $tiiassignment = $DB->get_record('plagiarism_turnitin_config', array('cm' => $cm->id, 'name' => 'turnitin_assignid'));

            echo html_writer::tag("div", turnitintooltwo_view::output_lti_form_launch('peermark_reviews',
                                                        $role, $tiiassignment->value),
                                                        array("class" => "launch_form", "style" => "display:none;"));
            echo html_writer::script("<!--
                                    window.document.forms[0].submit();
                                    //-->");
        }
        break;

    case "acceptuseragreement":
        $eula_user_id = required_param('user_id', PARAM_INT);

        // Get the id from the turnitintooltwo_users table so we can update
        $turnitin_user = $DB->get_record('turnitintooltwo_users', array('userid' => $eula_user_id));

        // Build user object for update
        $eula_user = new object();
        $eula_user->id += $turnitin_user->id;
        $eula_user->userid = $eula_user_id;
        $eula_user->user_agreement_accepted = 1;

        // Update the user using the above object
        $DB->update_record('turnitintooltwo_users', $eula_user, $bulk=false);
        break;
}

if (!empty($return)) {
    echo json_encode($return);
}