<?php // Test target which returns a selection of what it gets as JSON
$info = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'cookie' => $_COOKIE,
    'get' => $_GET,
    'post' => $_POST,
    'input' => file_get_contents('php://input'),
    'headers' => getallheaders(),
];

ob_start('ob_gzhandler');
header('Content-Type: application/json; charset=utf-8');
header('X-TestHeader: This header should come back through');
echo json_encode($info, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK | JSON_FORCE_OBJECT);
