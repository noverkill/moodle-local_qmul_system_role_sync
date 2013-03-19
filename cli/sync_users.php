<?php

/**
 * CLI sync for qmul_system_role_sync
 *
 * Sample cron entry:
 * # 5 minutes past 4am
 * 5 4 * * * $sudo -u www-data /usr/bin/php /var/www/moodle/enrol/database/cli/sync_users.php
 *
 * Notes:
 *   - it is required to use the web server account when executing PHP CLI scripts
 *   - you need to change the "www-data" to match the apache user account
 *   - use "su" if "sudo" not available
 *
 * @package    qmul_system_role_sync
 * @subpackage qmul_system_role_sync
 * @copyright  Greg Pasciak/QMUL
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);


require_once(dirname(__FILE__) . '/../../../config.php');
require_once(dirname(__FILE__) . '/../lib.php');
//require_once(dirname(__FILE__) . '/../settings.php');
require_once($CFG->libdir . '/../version.php');

local_qmul_system_role_sync_process();

