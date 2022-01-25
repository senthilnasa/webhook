<?php
//Complte File
function err(string $err,int $code=400): void
{
    $res = array();
    $res['ok'] = false;
    $res['err'] = $err;
    _finish($res,$code);
}

function complete($data): void
{
    $res = array();
    $res['ok'] = true;
    $res['data'] = $data;
    _finish($res);
}

function _finish(array $res,int $code=200): void
{
    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Pragma: no-cache');
    header('Content-Type: application/json');
    echo json_encode($res, JSON_PRETTY_PRINT);
    http_response_code($code);
    die();
}