<?php

header('Content-Type: application/json; charset=utf-8');

$filename = 'next.json';

if(!key_exists('next', $_GET))
{
    http_response_code(500);
    die('{"error":"Missing variable (next)"}');
    exit;
}
elseif(!isset($_GET['next']) or !$_GET['next'])
{
    http_response_code(500);
    die('{"error":"Variable is empty (next)"}');
    exit;
}

$content = '{"time":"'.time().'","video":"'.$_GET['next'].'"}';

if(!file_exists('video/'.$_GET['next']))
{
    http_response_code(500);
    die('{"error":"Video does not exist ('.$_GET['next'].')"}');
    exit;
}
elseif (is_writable($filename)) 
{

    if (!$fp = fopen($filename, 'w')) 
    {
        http_response_code(500);
        die('{"error":"Cannot open file ('.$filename.')"}');
        exit;
    }

    if (fwrite($fp, $content) === FALSE) 
    {
        http_response_code(500);
        die('{"error":"Cannot open file ('.$filename.')"}');
        exit;
    }

    die('{"success":"File updated ('.$filename.')"}');

    fclose($fp);

} 
else 
{

    http_response_code(500);
    die('{"error":"File is not writable ('.$filename.')"}');

}

/*
echo '<pre>';
print_r($_GET);
echo '</pre>';
*/