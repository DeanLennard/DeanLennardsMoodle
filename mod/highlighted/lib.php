<?php
/**
 * Highlighted module lib
 *
 * @package    mod
 * @subpackage highlighted
 * @copyright  2012 onwards Dean Lennard (PsyberPixie) {@link http://www.lawfullychaotic.co.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/// STANDARD FUNCTIONS ///////////////////////////////////////////////////////////
/**
 * @global object
 * @param object $highlighted
 * @return int
 */
function highlighted_add_instance($highlighted) {
    global $DB;
/// Given an object containing all the necessary data,
/// (defined by the form in mod_form.php) this function
/// will create a new instance and return the id number
/// of the new instance.

    $highlighted->timecreated  = time();
    $highlighted->timemodified = $highlighted->timecreated;

    $returnid = $DB->insert_record("highlighted", $highlighted);
    $highlighted->id = $returnid;

    return $returnid;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global object
 * @global object
 * @param object $highlighted
 * @return bool
 */
function highlighted_update_instance($highlighted) {
    global $CFG, $DB;

    $highlighted->timemodified = time();
    $highlighted->id           = $highlighted->instance;

    $DB->update_record("highlighted", $highlighted);

    return true;
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @global object
 * @param int $id highlighted id
 * @return bool success
 */
function highlighted_delete_instance($id) {
    global $DB, $CFG;

    if (!$highlighted = $DB->get_record('highlighted', array('id'=>$id))) {
        return false;
    }

    if (!$cm = get_coursemodule_from_instance('highlighted', $id)) {
        return false;
    }

    if (!$context = get_context_instance(CONTEXT_MODULE, $cm->id)) {
        return false;
    }

    return $DB->delete_records('highlighted', array('id'=>$id));
}

/**
 * Return a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $highlighted
 * @return object|null
 */
function highlighted_user_outline($course, $user, $mod, $highlighted) {
    global $DB;

	if ($logs = $DB->get_records('log', array('userid'=>$user->id, 'module'=>'highlighted',
                                              'action'=>'view', 'info'=>$highlighted->id), 'time ASC')) {

        $numviews = count($logs);
        $lastlog = array_pop($logs);

        $result = new stdClass();
        $result->info = get_string('numviews', '', $numviews);
        $result->time = $lastlog->time;

        return $result;
    }
    return NULL;
}

/**
 * Print a detailed representation of what a  user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @global object
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $highlighted
 */
function highlighted_user_complete($course, $user, $mod, $highlighted) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in glossary activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @global object
 * @global object
 * @global object
 * @param object $course
 * @param object $viewfullnames
 * @param int $timestart
 * @return bool
 */
function highlighted_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;  //  True if anything was printed, otherwise false
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 * @return bool
 */
function highlighted_cron () {
    return true;
}
