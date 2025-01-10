<?php

class DatabaseBackup {
    private $user;
    private $password;
    private $dbname;
    private $bk_path;

    public function __construct($user, $password, $dbname, $bk_path) {
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->bk_path = $bk_path;

        
    }

    public function __destruct() {
        $name_output =  $this->dbname . "_" . date('Y-m-d_H-i-s') . '.sql';
        $backupFile = $this->bk_path . $name_output;
        $command = "mysqldump --opt -u {$this->user} -p{$this->password} {$this->dbname} > {$backupFile}";

        // Execute the command
        system($command, $output);
        
        // Check if the backup was successful
        if($output !== 0) {
            throw new Exception('Error while taking backup.');
        }

        // Deliver the backup file to the browser
        $this->downloadFile($backupFile);
    }

    private function downloadFile($file) {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        } else {
            throw new Exception('Backup file does not exist.');
        }
    }
}
