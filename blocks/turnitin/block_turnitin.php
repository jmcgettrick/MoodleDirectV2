<?php

require_once($CFG->dirroot.'/mod/turnitintooltwo/lib.php');

class block_turnitin extends block_base {
    public function init() {
        $this->title = get_string('turnitin', 'turnitintooltwo');
    }

    public function get_content() {
    	global $CFG, $OUTPUT, $USER, $PAGE, $DB;

    	if ($this->content !== null) {
			return $this->content;
		}

		$output = '';

		if (!empty($USER->id)) {
			$jsurl = new moodle_url($CFG->wwwroot.'/mod/turnitintooltwo/scripts/jquery-1.8.2.min.js');
        	$PAGE->requires->js($jsurl, true);
        	$jsurl = new moodle_url($CFG->wwwroot.'/mod/turnitintooltwo/scripts/block_turnitin.js');
        	$PAGE->requires->js($jsurl, true);

	        $cssurl = new moodle_url($CFG->wwwroot.'/mod/turnitintooltwo/css/styles_block.css');
        	$PAGE->requires->css($cssurl);

	        $output .= $OUTPUT->box($OUTPUT->pix_icon('loader', '', 'mod_turnitintooltwo'), 'centered_cell', 'block_loading');
	        $output .= html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/extras.php?cmd=courses',
	        							html_writer::tag('noscript', get_string('coursestomigrate', 'mod_turnitintooltwo', '')), array('id' => 'block_migrate_content'));
        }

	    $this->content = new stdClass;
	    $this->content->text = $output;
	    $this->content->footer = '';

	    return $this->content;
    }
}