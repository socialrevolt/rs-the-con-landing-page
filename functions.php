<?php

function rewardstyle_gatekeeper($env) {
    if (! ($env && ($env == 'prod')) ) {
        # only filtering if in a prod context
        return;
    }
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_path = parse_url($request_uri)["path"];
    if ($request_path != '' && $request_path != '/' && $request_path != '/index.php' && $request_path != '/index.html') {
        # only gatekeeping the index page
        # so return early
        return;
    }

    $status_con_invited = 1024;

    $path = realpath(dirname(__FILE__));
    require_once $path . '/RewardstyleDB.php';
    require_once $path . '/RewardstyleUser.php';

    $prev_error_reporting = error_reporting();
    error_reporting(1);

    if ($env == 'prod') {
        RewardstyleDB::$default = array(
            'mysql:host=pub-ro-db.rewardstyle.com;dbname=rewardstyle;charset=utf8', # dsn
            'ro-rstheconf', # user
            'Jp657crYvDuE8EGZ4uJKjRqd' # pass
        );
        $rs_proto_host = 'https://www.rewardstyle.com';
        $rs_proto_auth_host = 'https://auth.rewardstyle.com';
        $conf_proto_host = 'http://rsthecon.rewardstyle.com';
    }

    // check if the user is logged in
    $logged_in = RewardstyleUser::get_logged_in();
    if (!$logged_in) {
        // if not, redirect them to the rewardStyle login passing a redirect back here
        header('Location: ' . $rs_proto_auth_host . '/login/?next=' . urlencode($conf_proto_host . '/' . ltrim($request_uri, '/')), true, 302);
        exit(0);
    } else {
        // check if the account status contains the invited flag
        if (!(RewardstyleUser::get_status_by_id($logged_in) & $status_con_invited)) {
            // if not redirect them back to rewardStyle.com
            header('Location: ' . $rs_proto_host . '/', true, 302);
            exit(0);
        }
    }

    error_reporting($prev_error_reporting);
}
rewardstyle_gatekeeper(($_SERVER['SERVER_NAME'] == 'rsthecon.rewardstyle.com' || $_SERVER['SERVER_NAME'] == 'rstheconprod.wpengine.com') ? 'prod' : null);






function theme_loader($directory)
{
	$pattern = $directory.'/*';
	foreach(glob($pattern) as $file){
		if(is_dir($file)){
			theme_loader($file);
		} else {
			include_once $file;
		}
	}
}

theme_loader(dirname(__FILE__) . '/dist/lib');
