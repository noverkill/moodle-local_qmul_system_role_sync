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

/**
 * Lib functions (cron) to automatically JP Students
 * if it was not done all at once during the main upgrade.
 *
 * @package    local
 * @subpackage qmul_system_role_sync
 * @copyright  Greg Pasciak/QMUL
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Standard cron function
 */
function local_qmul_system_role_sync_cron() {
    $settings = get_config('local_qmul_system_role_sync');
    if (empty($settings->cronenabled)) {
        return;
    }

    mtrace('qmul_system_role_sync: local_qmul_system_role_sync_cron() started at '. date('H:i:s'));
    try {
        local_qmul_system_role_sync_process($settings);
    } catch (Exception $e) {
        mtrace('qmul_system_role_sync: local_qmul_system_role_sync_cron() failed with an exception:');
        mtrace($e->getMessage());
    }
    mtrace('qmul_system_role_sync: local_qmul_system_role_sync_cron() finished at ' . date('H:i:s'));
}

/**
 * This function does the cron process within the time range according to settings.
 */
function local_qmul_system_role_sync_process() {
    global $CFG;
    require_once(dirname(__FILE__) . '/locallib.php');

    if (!local_qmul_system_role_sync_is_upgraded()) {
        mtrace('qmul_system_role_sync: site not yet upgraded. Doing nothing.');
        return;
    }

    require_once(dirname(__FILE__) . '/afterupgradelib.php');

    $hour = (int) date('H');
    if ($hour < $settings->starthour || $hour >= $settings->stophour) {
        mtrace('qmul_system_role_sync: not between starthour and stophour, so doing nothing (hour = ' .
                $hour . ').');
        return;
    }

    $stoptime = time() + $settings->procesingtime;

    mtrace('qmul_system_role_sync: processing ...');
    while (time() < $stoptime) {

        $quiz = local_qeupgradehelper_get_quiz_for_upgrade();
        if (!$quiz) {
            mtrace('qmul_system_role_sync: No more quizzes to process. You should probably disable the qmul_system_role_sync cron settings now.');
            break; // No more to do;
        }

        $quizid = $quiz->id;
        $quizsummary = local_qeupgradehelper_get_quiz($quizid);
        if ($quizsummary) {
            mtrace('  starting upgrade of attempts at quiz ' . $quizid);
            $upgrader = new local_qeupgradehelper_attempt_upgrader(
                    $quizsummary->id, $quizsummary->numtoconvert);
            $upgrader->convert_all_quiz_attempts();
            mtrace('  upgrade of quiz ' . $quizid . ' complete.');
        }
    }

    mtrace('qmul_system_role_sync: Done.');
    return;
}
