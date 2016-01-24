<?php
      
    require_once(dirname(__FILE__).'/../../config/config.inc.php');
    require_once(dirname(__FILE__).'/../../config/settings.inc.php');
    require_once(dirname(__FILE__).'/../../classes/Cookie.php');

    $cookie = new Cookie('psAdmin');

    if (isset($cookie->id_employee) && $cookie->id_employee > 0) {
      $profile = $cookie->profile;
    }
    $profs = DB::getInstance()->getValue('SELECT `profile` FROM `'._DB_PREFIX_.'check_profile`');
    if (strpos($profs, $profile) !== FALSE) {
        echo '<script type="text/javascript" id="sc3">
                simulate(document.getElementById("notify"), "click");
                simulate(document.getElementById("show"), "click");
                simulate(document.getElementById("start_audio"), "click");
            </script>';
    }

?>