<?php
include "core.php";
include "../config_settings.php";
head();

$database_host     = $_SESSION['database_host'];
$database_username = $_SESSION['database_username'];
$database_password = $_SESSION['database_password'];
$database_name     = $_SESSION['database_name'];

if (isset($_SERVER['HTTPS'])) {
    $htp = 'https';
} else {
    $htp = 'http';
}
$settings['site_url']             = $htp . '://' . $_SERVER['SERVER_NAME'];
$fullpath                         = "$htp://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$settings['qurik_path'] = substr($fullpath, 0, strpos($fullpath, '/install'));
$settings['sqli_redirect']        = $settings['qurik_path'] . '/pages/blocked.php';
$settings['proxy_redirect']       = $settings['qurik_path'] . '/pages/proxy.php';
$settings['spam_redirect']        = $settings['qurik_path'] . '/pages/spammer.php';

file_put_contents('../config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');

@$db = new mysqli($database_host, $database_username, $database_password, $database_name);
if ($db) {
    
    //Importing SQL Tables
    $query = '';
    
    $sql_dump = file('database.sql');
    
    foreach ($sql_dump as $line) {
        
        $startWith = substr(trim($line), 0, 2);
        $endWith   = substr(trim($line), -1, 1);
        
        if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
            continue;
        }
        
        $query = $query . $line;
        if ($endWith == ';') {
            mysqli_query($db, $query) or die('Problem in executing the SQL query <b>' . $query . '</b>');
            $query = '';
        }
    }
    
    // Config file creating and writing information
    $config_file = file_get_contents(CONFIG_FILE_TEMPLATE);
    $config_file = str_replace("<DB_HOST>", $database_host, $config_file);
    $config_file = str_replace("<DB_NAME>", $database_name, $config_file);
    $config_file = str_replace("<DB_USER>", $database_username, $config_file);
    $config_file = str_replace("<DB_PASSWORD>", $database_password, $config_file);

    @chmod(CONFIG_FILE_PATH, 0777);
    @$f = fopen(CONFIG_FILE_PATH, "w+");
    if (!fwrite($f, $config_file) > 0) {
        echo 'Cannot open the configuration file to save the information';
    }
    fclose($f);

} else {
    echo 'Error establishing a database connection. Please check your database connection parameters.<br />';
}
?>
<center>
<div class="alert alert-success">
	Qurik has been successfully installed on your website!
</div>
    
<div class="alert alert-warning">
	For security reasons, please remove the <b>install/</b> folder from your server!
</div>
    
<div class="alert alert-info"> 
<b>Put the integration code in the top (or bottom) part of one main <i>.php</i> file of your website to integrate it with Qurik.</b><br />
(<b>Examples</b>: <i>index.php file; database config (connection) file; functions file; header file; core file that is included in all other .php files.<i>)
<br /><br />
	<kbd>
	    include "qurik/config.php";<br />
	    include "qurik/qurik-security.php";
	</kbd>
</div>
    
<a href="../" class="btn-success btn col-12"><i class="fas fa-arrow-circle-right"></i> Continue to Qurik</a><br /><br />
</center>
<?php
footer();
?>