#!/usr/bin/php
<?
try {
//daily cron
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://campusbullet.net/system/cron");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                'curl_key' => 'SECRETKEY'));

        $data = curl_exec($curl);

        if ($data != "OK") {
                echo "ERROR. Data returned: $data";
        }
//database backup

        $db_user = 'campusbullet';
        $db_pw = 'MY76D7wpLwZASJqY';
        $directory = "/var/www/backups";
        $number = 1;
        $date = date("Y-m-d");
        while (file_exists("$directory/campusbullet_{$date}_$number.sql.gz"))
                $number++;
        $filehandle = fopen("$directory/campusbullet_{$date}_$number.sql",'w');

        $db_data = array();
        exec("mysqldump --opt -u$db_user -p$db_pw campusbullet",$db_data);

        $sql_lines = "";
        foreach ($db_data as $line)
                $sql_lines .= "$line\r\n";

        fwrite($filehandle,$sql_lines);
        fclose($filehandle);

        exec("gzip $directory/campusbullet_{$date}_$number.sql");

        exec("tar -czf $directory/campusbullet_{$date}_$number.tgz /var/www/campusbullet");

} catch (Exception $e) {
        echo "FAIL: " . print_r($e, true);
}
?>
