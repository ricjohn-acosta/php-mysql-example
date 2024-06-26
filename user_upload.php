<?php
require_once "db.php";
require_once "./controllers/user_upload.php";

global $db;

if (isset($argv)) {
    if (in_array("--help", $argv)) {
        echo "
         ###################################################################################################
         #                                                                                                 #
         #   Welcome to Catalyst User Uploader! Your one stop shop for your user uploading needs!          #
         #                                                                                                 #
         #   You may use the following flags:                                                              #
         #                                                                                                 #
         #   --file [csv file name]  = upload users into the database                                      #
         #   --create_table          = creates a users table in mysql                                      #
         #   --dry_run               = to be used in conjunction with --file flag to run the application   #
         #                             without modifying the database                                      #
         #                             e.g: php user_upload.php --dry_run --file users.csv                 #
         #                                                                                                 #
         #   -u                      = display mysql username                                              #
         #   -p                      = display mysql password                                              #
         #   -h                      = display mysql host                                                  #
         #   --help                  = display help menu                                                   #
         #                                                                                                 #
         ###################################################################################################
        ";
        return;
    }

    if (in_array("--file", $argv) && !in_array("--dry_run", $argv)) {
        if (!$db->database_exists()) {
            echo "Table does not exist! You may need to run php user_upload.php --create_table first.";
            return;
        }

        $filename = get_file($argv);

        if ($filename) {
            upload_file($filename);
        } else {
            echo "Incorrect usage. (e.g: php user_upload.php --file users.csv)";
        }

        return;
    }

    if (in_array("--dry_run", $argv) && in_array("--file", $argv)) {
        if (!$db->database_exists()) {
            echo "Table does not exist! You may need to run php user_upload.php --create_table first.";
            return;
        }

        $filename = get_file($argv);

        if ($filename) {
            upload_file($filename, true);
        } else {
            echo "Incorrect usage. (e.g: php user_upload.php --dry_run --file users.csv)";
        }

        return;
    } else if (in_array("--dry_run", $argv)){
        echo "Incorrect usage. (e.g: php user_upload.php --dry_run --file users.csv)";
        return;
    }

    if (in_array("--create_table", $argv)) {
        $db->create();
        return;
    }

    if (in_array("-p", $argv)) {
        echo "MySQL password: {$db->getDbPassword()}";
        return;
    }

    if (in_array("-u", $argv)) {
        echo "MySQL username: {$db->getDbUsername()}";
        return;
    }

    if (in_array("-h", $argv)) {
        echo "MySQL host: {$db->getDbHost()}";
        return;
    }

    echo "Invalid command!";
}

function upload_file($filename, $dry_run = false): void
{
    $uploader = new User_upload();
    $uploader->upload($filename, $dry_run);
}

function get_file($argv): string
{
    $filename = NULL;

    foreach ($argv as $arg) {
        if (str_contains($arg, "csv")) {
            $filename = $arg;
        }
    }

    return $filename;
}
