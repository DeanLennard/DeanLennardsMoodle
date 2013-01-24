<?php
/**
 * Highlighted module index
 *
 * @package    mod
 * @subpackage highlighted
 * @copyright  2012 onwards Dean Lennard (PsyberPixie) {@link http://www.lawfullychaotic.co.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once("lib.php");

$id = required_param('id', PARAM_INT);   // course

$PAGE->set_url('/mod/highlighted/index.php', array('id'=>$id));

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    print_error('invalidcourseid');
}

require_course_login($course);
$PAGE->set_pagelayout('incourse');
$context = get_context_instance(CONTEXT_COURSE, $course->id);

add_to_log($course->id, "highlighted", "view all", "index.php?id=$course->id", "");

/// Get all required strings

$strappearance  = get_string("modulename", "highlighted");
$strrss = get_string("rss");

/// Print the header
$PAGE->navbar->add($strappearance, "index.php?id=$course->id");
$PAGE->set_title($strappearance);
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();

/// Finish the page

echo $OUTPUT->footer();