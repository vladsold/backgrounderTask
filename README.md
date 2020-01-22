# Example

    $param = 1;
    $bg = new classBackgroundTaskLinux();
    $pid = $bg->launch("/var/www/index.php ".$param, 18000, false);
