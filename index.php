<?php

    require_once __DIR__."/handler.php";
    $_path = explode("/", $_SERVER['PATH_INFO'] ?? $_SERVER['REDIRECT_URL'] ?? null);
    if(isset($_GET['_path'])){
        $_path = $_GET['_path'];
    }

    $path = explode("/", $_path);
    $appName = $path[1] ?? null;
    $isdebug = $_GET['debug'] ?? false == true; 
    $appToken = $path[2] ?? null;
    
    
    if (!$appName) {
        err('Missing Application Name !',400);
    }
    
    if (!$appToken) {
        err('Missing Application token !',400);
    }
    
    $appName = strtolower(preg_replace('@[^0-9a-z\-\_]@is', '', $appName));
    
    $config = @file_get_contents(__DIR__."/config/" . $appName . ".json");
    
    if (!$config) {
        err('Invalid Webhook Request !',400);
    }


    if ($config) {
        $config = json_decode($config, true);
    }
    
    if(!isset($config['appToken'])){
        err('Invalid Config ! AppToken not Defined ',403);
    }
    if ($appToken != $config['appToken']) {
        err('Forbidden Webhook Request !',403);
    }
    
    foreach ($config['scripts'] as $script) {
        $response = [];
        exec($script.' 2>&1', $response, $status);
        if ($isdebug) {
            echo '<strong>'.$script.'</strong><br><pre>';
            foreach ($response as $res) {
                echo $res.'<br>';
            }
            echo '</pre><br><br>';
        }
        
    }

    if (!$isdebug) {
        complete(date("d/M/Y  - h:i:sa"));
    }


    // Nginx onfig
    
    // location / {
                
    //     try_files $uri $uri/ /index.php?path=$uri&$args;
    
    //     # try_files $uri $uri/ =404;
    // }
    
    // location ~ \.php$ {
    //     include snippets/fastcgi-php.conf;
    //     fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    // }
?>

