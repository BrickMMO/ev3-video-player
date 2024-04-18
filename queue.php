<?php

header('Content-Type: application/json; charset=utf-8');

// ********************************************************************************
// ********************************************************************************
// ********************************************************************************
// Validation
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

// ********************************************************************************
// ********************************************************************************
// ********************************************************************************
// Record button press
$filename = 'results-'.date('Y').'-'.date('m').'-'.date('d').'.csv';
$results = fopen($filename, "a+");
$content = time().','.$_GET['next'].chr(13);
fwrite($results, $content);
fclose($results);

// ********************************************************************************
// ********************************************************************************
// ********************************************************************************
// Prepare next.json file
$filename = 'next.json';
$content = '{"time":"'.time().'","video":"'.$_GET['next'].'"}';

if(!file_exists('video/'.$_GET['next']))
{
    http_response_code(500);
    die('{"error":"Video does not exist ('.$_GET['next'].')"}');
    exit;
}
elseif (is_writable($filename)) 
{

    if (!$next = fopen($filename, 'w')) 
    {
        http_response_code(500);
        die('{"error":"Cannot open file ('.$filename.')"}');
        exit;
    }

    if (fwrite($next, $content) === FALSE) 
    {
        http_response_code(500);
        die('{"error":"Cannot open file ('.$filename.')"}');
        exit;
    }

    die('{"success":"File updated ('.$filename.')"}');

    fclose($next);

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