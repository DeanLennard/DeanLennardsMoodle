<?php

require_once("../../config.php");
require_once("lib.php");
require_once("locallib.php");

$id = required_param('id', PARAM_INT);   // highlighted id
$highlight = optional_param('highlight', 0, PARAM_INT);   // Highlight the keywords

$PAGE->set_url('/mod/highlighted/view.php', array('id'=>$id));

if (! $cm = get_coursemodule_from_id('highlighted', $id)) {
	print_error('invalidcoursemodule');
}
if (! $course = $DB->get_record("course", array("id" => $cm->course))) {
	print_error('coursemisconf');
}

require_course_login($course);
$PAGE->set_pagelayout('incourse');
$context = get_context_instance(CONTEXT_COURSE, $course->id);

add_to_log($course->id, "highlighted", "view all", "index.php?id=$course->id", "");

$highlighted = $DB->get_record('highlighted', array('id' => $cm->instance));
$keywords = new highlighted_keywords;
$highlightlink = $CFG->wwwroot.'/mod/highlighted/view.php?id='.$id.'&highlight=1';
$highlight_button = html_writer::tag('a', get_string('highlight_keywords', 'highlighted'), array('href' => $highlightlink));
$unhighlightlink = $CFG->wwwroot.'/mod/highlighted/view.php?id='.$id;
$unhighlight_button = html_writer::tag('a', get_string('unhighlight_keywords', 'highlighted'), array('href' => $unhighlightlink));

/// Get all required strings
$strhighlightkeyword = get_string("modulename", "highlighted");
$strrss = get_string("rss");

/// Print the header
$PAGE->navbar->add($strhighlightkeyword, "index.php?id=$course->id");
$PAGE->set_title($strhighlightkeyword);
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();

// Page Content

echo html_writer::tag('h1', $highlighted->name);
echo html_writer::start_tag('div', array('class' => 'highlight_text'));
if($highlight > 0){
	echo $keywords->highlight($highlighted->intro, $highlighted->keywords);
}else{
	echo $highlighted->intro;
}

if($highlight > 0){
	echo html_writer::tag('div', $unhighlight_button, array('class'=>'highlight_button'));
}else{
	echo html_writer::tag('div', $highlight_button, array('class'=>'highlight_button'));
}

echo html_writer::end_tag('div');

/// Finish the page

echo $OUTPUT->footer();