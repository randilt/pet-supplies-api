<?php
$configFile = 'config.json';
if (file_exists($configFile)) {
    $config = json_decode(file_get_contents($configFile), true);

    if (isset($config['env'])) {
        define('ENV', $config['env']);
    } else {
        throw new Exception('Key "env" not found in config.json');
    }
} else {
    throw new Exception('config.json file not found');
}
