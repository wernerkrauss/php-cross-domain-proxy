<?php // Test target which returns a selection of what it gets as JSON
$info = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'cookie' => $_COOKIE,
    'get' => $_GET,
    'post' => $_POST,
    'input' => file_get_contents('php://input'),
    'headers' => getallheaders(),
];

header_remove();
ini_set('zlib.output_compression', 'On');

header('X-Test-Header: This header should come back through');
session_name('Test-Session');
session_start();
setcookie('Test-Cookie-A', uniqid());
setcookie('Test-Cookie-B', uniqid(), strtotime( '+1 days' ));

header('Content-Type: application/json; charset=utf-8');
echo json_encode(array_filter($info), JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK | JSON_FORCE_OBJECT);
