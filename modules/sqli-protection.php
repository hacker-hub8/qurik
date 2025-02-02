<?php
//SQLi Protection
if ($settings['sqli_protection'] == 1) {
    
    //XSS Protection - Block infected requests
    //@header("X-XSS-Protection: 1; mode=block");
    
	// XSS Protection - Sanitize infected requests
    if ($settings['sqli_protection2'] == 1) {
        
        @header("X-XSS-Protection: 1");
    }
    
	// Clickjacking Protection
    if ($settings['sqli_protection3'] == 1) {
        
        @header("X-Frame-Options: sameorigin");
    }
    
	// Prevents attacks based on MIME-type mismatch
    if ($settings['sqli_protection4'] == 1) {
        
        @header("X-Content-Type-Options: nosniff");
    }
    
	// Force secure connection
    if ($settings['sqli_protection5'] == 1) {
        
        @header("Strict-Transport-Security: max-age=15552000; preload");
    }
    
	// Hide PHP Version
    if ($settings['sqli_protection6'] == 1) {
		
        @header('X-Powered-By: qurik');
    }
    
	// Sanitization of all fields and requests
    if ($settings['sqli_protection7'] == 1) {
		
        $_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    // Data Sanitization
    if ($settings['sqli_protection8'] == 1) {
        
        if (!function_exists('cleanInput')) {
            function cleanInput($input)
            {
                $search = array(
                    '@<script[^>]*?>.*?</script>@si', // Strip out javascript
                    '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML and PHP tags
                    '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
                    '@<![\s\S]*?--[ \t\n\r]*>@' // Strip multi-line comments
                );
                
                $output = preg_replace($search, '', $input);
                return $output;
            }
        }
        
        if (!function_exists('sanitize')) {
            function sanitize($input)
            {
                if (is_array($input)) {
					$output = [];
                    foreach ($input as $var => $val) {
                        $output[$var] = sanitize($val);
                    }
                } else {
					$output = '';
					if($input == NULL) {
						$input = '';    
					}
                    $input  = str_replace('"', "", $input);
                    $input  = str_replace("'", "", $input);
                    $input  = cleanInput($input);
                    $output = htmlentities($input, ENT_QUOTES);
                }
                return @$output;
            }
        }
        
        $_POST    = sanitize($_POST);
        $_GET     = sanitize($_GET);
        $_REQUEST = sanitize($_REQUEST);
        $_COOKIE  = sanitize($_COOKIE);
        if (isset($_SESSION)) {
            $_SESSION = sanitize($_SESSION);
        }
    }
    
    $query_string = $_SERVER['QUERY_STRING'];
    
    // Patterns, used to detect Malicous Request (SQL Injection)
    $patterns = array(
        "**/",
        "/**",
        "0x3a",
        "/*",
        "*/",
        "||",
        "' #",
        "or 1=1",
		"or%201=1",
        "'1'='1",
        "S@BUN",
        "`",
        "'",
        '"',
        "<",
        ">",
        "1,1",
        "1=1",
        "sleep(",
        "<?",
        "<?php",
        "?>",
        "../",
        "%0A",
        "%0D",
        "%3C",
        "%3E",
        "%00",
        "%2e%2e",
        "input_file",
        "path=.",
        "mod=.",
        "eval\(",
        "javascript:",
        "base64_",
        "boot.ini",
        "etc/passwd",
        "self/environ",
        "echo.*kae",
        "=%27$",
        "* ( ) . & - _ [ ] ` ~ | @ $ % ^ ? : { } ! ' ",
        "-1'OR#foo",
        "id=IF#foo",
        "(ASCII#foo",
        "((SELECT-version()/1.))<250,1,0)",
        "! <1",
        "7357=1",
        "7357=true",
        "7357=y",
        "7357=yes",
        "access=1",
        "access=true",
        "access=y",
        "access=yes",
        "adm=1",
        "adm1n=1",
        "adm1n=true",
        "adm1n=y",
        "adm1n=yes",
        "admin=1",
        "admin=true",
        "admin=y",
        "admin=yes",
        "adm=true",
        "adm=y",
        "adm=yes",
        "dbg=1",
        "dbg=true",
        "dbg=y",
        "dbg=yes",
        "debug=1",
        "debug=true",
        "debug=y",
        "debug=yes",
        "edit=1",
        "edit=true",
        "edit=y",
        "edit=yes",
        "grant=1",
        "grant=true",
        "grant=y",
        "grant=yes",
        "test=1",
        "test=true",
        "test=y",
        "test=yes",
        "%00",
        "%01", 
        "%02", 
        "%03", 
        "%04",
        "%05",
        "%06", 
        "%07",
        "%08",
        "%09",
        "%0A",
        "%OB", 
        "%OC", 
        "%0D",
        "%0E",
        "%0F", 
        "%10", 
        "%11", 
        "%12",
        "%13",
        "%.0", 
        "%"",%",
        "&.0", 
        "&\N",
        "-.0",
        "\Ν",
        "<Θ.", 
        ">0.", 
        "еθ", 
        "^0.",  
        "1.0", 
        "|\N",
        "+-1",
        "@",
        "~",
        "",
        "l",
        "",
        "^/$$&@",
        ">=[]",
        "-",
        "\"$\"",
        "+@+",
        "@$%",
        "@&&\"",
        "@%ce%",
        "@%ce/",
        "@%FF\"",
        "\\N$\"",
        "\\N%FF\"",
        "1e1",
        "1.1",
        "\"\"",
        "%",
        ".1",
        "%\\N",
        "*\"\"",
        "***\"\"",
        "<.0?&&+=1.0",
        ".%20%20.",
        "7357":"1",
        "7357":"true",
        "7357":"y",
        "7357":"yes",
        "access":"1",
        "access":"true",
        "access":"y",
        "access":"yes",
        "adm":"1",
        "adm":"true",
        "adm":"y",
        "adm":"yes",
        "adm1n":"1",
        "adm1n":"true",
        "adm1n":"y",
        "adm1n":"yes",
        "admin":"1",
        "admin":"true",
        "admin":"y",
        "admin":"yes",
        "adm":"1",
        "adm":"true",
        "adm":"y",
        "adm":"yes",
        "dbg":"1",
        "dbg":"true",
        "dbg":"y",
        "dbg":"yes",
        "debug":"1",
        "debug":"true",
        "debug":"y",
        "debug":"yes",
        "edit":"1",
        "edit":"true",
        "edit":"y",
        "edit":"yes",
        "grant":"1",
        "grant":"true",
        "grant":"y",
        "grant":"yes",
        "test":"1",
        "test":"true",
        "test":"y",
        "test":"yes",
        "0",
        "1",
        "add",
        "admin",
        "alert",
        "alter",
        "auth",
        "authenticate",
        "append",
        "calc",
        "calculate",
        "cancel",
        "change",
        "check",
        "clear",
        "click",
        "clone",
        "close",
        "create",
        "crypt",
        "decrypt",
        "del",
        "delete",
        "demo",
        "disable",
        "dl",
        "download",
        "edit",
        "enable",
        "encrypt",
        "exec",
        "execute",
        "file",
        "focus",
        "get",
        "help",
        "initiate",
        "is",
        "list",
        "load",
        "ls",
        "make",
        "mod",
        "mode",
        "modify",
        "move",
        "new",
        "off",
        "on",
        "open",
        "post",
        "proxy",
        "pull",
        "put",
        "query",
        "read",
        "remove",
        "rename",
        "reset",
        "retrieve",
        "run",
        "save",
        "search",
        "send",
        "shell",
        "show",
        "snd",
        "subtract",
        "test",
        "to",
        "toggle",
        "update",
        "upload",
        "verify",
        "view",
        "vrfy",
        "with",
        "3fexe.asp",
        "ASpy.asp",
        "EFSO.asp",
        "RemExp.asp",
        "aspxSH.asp",
        "aspxshell.aspx",
        "aspydrv.asp",
        "cmd.asp",
        "cmd.aspx",
        "cmdexec.aspx",
        "elmaliseker.asp",
        "filesystembrowser.aspx",
        "fileupload.aspx",
        "ntdaddy.asp",
        "spexec.aspx",
        "sql.aspx",
        "tool.asp",
        "tool.aspx",
        "toolaspshell.asp",
        "up.asp",
        "up.aspx",
        "zehir.asp",
        "zehir.aspx",
        "zehir4.asp",
        "zehir4.aspx",
        "cmd-asp-5.1.asp",
        "cmdasp.asp",
        "cmdasp.aspx",
        "list.asp",
        "/*.gif",
        "/*.gif/",//Weblogic.txt
        "/*.html",
        "/*.jsp",
        "/*.jsp/",
        "/*.jws",
        "/*.shtml/",
        "/AdminCaptureRootCA",
        "/AdminClients",
        "/AdminConnections",
        "/AdminEvents",
        "/AdminJDBC",
        "/AdminLicense",
        "/AdminMain",
        "/AdminProps",
        "/AdminRealm",
        "/AdminThreads",
        "/AdminVersion",
        "/BizTalkServer",
        "/Bootstrap",
        "/Certificate",
        "/Classpath/",
        "/ConsoleHelp/",
        "/ConsoleHelp",
        "/DefaultWebApp",
        "/HTTPClntClose",
        "/HTTPClntLogin",
        "/HTTPClntRecv",
        "/HTTPClntSend",
        "/LogfileSearch",
        "/LogfileTail",
        "/Login.jsp",
        "/MANIFEST.MF",
        "/META-INF",
        "/SimpappServlet",
        "/StockServlet",
        "/T3AdminMain",
        "/UniversityServlet",
        "/WEB-INF",
        "/WEB-INF./web.xml",
        "/WEB-INF/web.xml",
        "/WLDummyInitJVMIDs",
        "/WebServiceServlet",
        "/_tmp_war",
        "/_tmp_war_DefaultWebApp",
        "/a2e2gp2r2/x.jsp",
        "/actions",
        "/admin/login.do",
        "/applet",
        "/applications",
        "/authenticatedy",
        "/bea_wls_internal/classes/",
        "/bea_wls_internal/classes/",
        "/bea_wls_internal/WebServiceServlet",
        "/bea_wls_internal/getior",
        "/bea_wls_internal",
        "/bea_wls_internal/HTTPClntSend",
        "/bea_wls_internal/HTTPClntRecv",
        "/bea_wls_internal/iiop/ClientSend",
        "/bea_wls_internal/iiop/ClientRecv",
        "/bea_wls_internal/iiop/ClientLogin",
        "/bea_wls_internal/WLDummyInitJVMIDs",
        "/bea_wls_internal/a2e2gp2r2/x.jsp",
        "/bea_wls_internal/psquare/x.jsp",
        "/bea_wls_internal/iiop/ClientClose",
        "/beanManaged",
        "/certificate",
        "/classes",
        "/classes/",
        "/com",
        "/common",
        "/config",
        "/console",
        "/cookies",
        "/default",
        "/docs51",
        "/domain",
        "/drp-exports",
        "/drp-publish",
        "/dummy",
        "/e2ePortalProject/Login.portal",
        "/ejb",
        "/ejbSimpappServlet",
        "/error",
        "/examplesWebApp/EJBeanManagedClient.jsp",
        "/examplesWebApp/WebservicesEJB.jsp",
        "/examplesWebApp/OrderParser.jsp?xmlfile=C:/bea/weblogic81/samples/server/examples/src/examples/xml/orderParser/order.xml",
        "/examplesWebApp/index.jsp",
        "/examplesWebApp/InteractiveQuery.jsp",
        "/examplesWebApp/SessionServlet",
        "/fault",
        "/file",
        "/file/",
        "/fileRealm",
        "/fileRealm.properties",
        "/getior",
        "/graphics",
        "/helloKona",
        "/helloWorld",
        "/iiop/ClientClose",
        "/iiop/ClientRecv",
        "/iiop/ClientLogin",
        "/iiop/ClientSend",
        "/images",
        "/index",
        "/index.jsp",
        "/internal",
        "/jmssender",
        "/jmstrader",
        "/jspbuild",
        "/jwsdir",
        "/login.jsp",
        "/manifest.mf",
        "/mapping",
        "/mydomain",
        "/myservlet",
        "/page",
        "/patient/login.do",
        "/patient/register.do",
        "/phone",
        "/physican/login.do",
        "/portalAppAdmin/login.jsp",
        "/properties",
        "/proxy",
        "/psquare/x.jsp",
        "/public_html",
        "/servlet",
        "/servletimages",
        "/servlets/",
        "/session",
        "/simpapp",
        "/simple",
        "/simpleFormServlet",
        "/snoop",
        "/survey",
        "/system",
        "/taglib-uri",
        "/uddi",
        "/uddi/uddilistener",
        "/uddiexplorer",
        "/uddilistener",
        "/utils",
        "/web",
        "/web.xml",
        "/weblogic",
        "/weblogic.properties",
        "/weblogic.xml",
        "/webservice",
        "/webshare",
        "/wl_management_internal2/FileDistribution",
        "/wl_management_internal2/Bootstrap",
        "/wl_management_internal2/Admin",
        "/wl_management_internal2/wl_management",
        "/wl_management_internal1/LogfileTail",
        "/wl_management_internal1/LogfileSearch",
        "/wl_management_internal1",
        "/wl_management",
        "/wl_management_internal2",
        "/wliconsole",
        "/wlserver",




    );
    foreach ($patterns as $pattern) {
        if (strpos(strtolower($query_string), strtolower($pattern)) !== false) {
            $querya = strip_tags(addslashes($query_string));
            $type   = "SQLi";

            // Logging
            if ($settings['sqli_logging'] == 1) {
                qurik_logging($mysqli, $type);
            }
            
            // AutoBan
            if ($settings['sqli_autoban'] == 1) {
                qurik_autoban($mysqli, $type);
            }
            
            // E-Mail Notification
            if ($settings['mail_notifications'] == 1 && $settings['sqli_mail'] == 1) {
                qurik_mail($mysqli, $type);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $settings['sqli_redirect'] . '" />';
            exit;
        }
    }
}
?>