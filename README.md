qmul_system_role_sync
=====================

qmul_system_role_sync enrolls all student from chosen file to JP Student role on the system context


Hardcoded values:


\cli\sync_users.php
    line 47:    -   replace user and password for user with 'moodle/site:config' capability

        $user = authenticate_user_login('admin', 'Pa5$w0rd');    // authenticate musername in moodle




\lib.php
    line 33:    -   change the path to the csv file if needed

        $config->filepath = '//u//web//qmulmis//mis_uploads//';      //location pointed to QMUL by ULCC to upload MIS and other files


    line 36:    -   change the file name if different

        $config->filename = 'BUPT_accounts.csv';                    // filename containing all JP Students usernames


    line 39:    -   role to assign to the system context

         $config->rolename = 'JP Student';                           // role name to assign on the system level