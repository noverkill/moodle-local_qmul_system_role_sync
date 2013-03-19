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
 * qmul_system_role_sync plugin settings and presets.
 *
 * @package    qmul_system_role_sync
 * @subpackage qmul_system_role_sync
 * @copyright  Greg Pasciak/QMUL
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('local_qmul_system_role_sync_settings', '', get_string('pluginname_desc', 'local_qmul_system_role_sync')));

    $settings->add(new admin_setting_configtext('local_qmul_system_role_sync/location', get_string('location', 'local_qmul_system_role_sync'), '', ''));

    $settings->add(new admin_setting_configcheckbox('local_qmul_system_role_sync/mailstudents', get_string('mailstudents', 'local_qmul_system_role_sync'), '', 0));

    $settings->add(new admin_setting_configcheckbox('local_qmul_system_role_sync/mailteachers', get_string('mailteachers', 'local_qmul_system_role_sync'), '', 0));

    $settings->add(new admin_setting_configcheckbox('local_qmul_system_role_sync/mailadmins', get_string('mailadmin', 'local_qmul_system_role_sync'), '', 0));

    //--- mapping -------------------------------------------------------------------------------------------
    if (!during_initial_install()) {
        $settings->add(new admin_setting_heading('local_qmul_system_role_sync_mapping', get_string('mapping', 'local_qmul_system_role_sync'), ''));

        $roles = $DB->get_records('role', null, '', 'id, name, shortname');

        foreach ($roles as $id => $record) {
            $settings->add(new admin_setting_configtext('local_qmul_system_role_sync/map_'.$id, format_string($record->name), '', format_string($record->shortname)));
        }
    }
}
