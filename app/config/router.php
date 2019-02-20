<?php
/***
 * All HTTP requests entry point
 */

require_once __DIR__ . "/bootstrap.php";

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$components = [];
foreach (explode('/', substr($url, 1)) as $nameComponent) {
    if ($nameComponent) {
        $components[] = ucfirst($nameComponent);
    }
}

$controllerClass = join('', $components) . "Controller";
$controllerPath = ROOT . "/app/controllers/{$controllerClass}.php";

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controller = new $controllerClass;
    $controller->action();
} else {
    header("HTTP/1.0 404 Not Found");
}

flush();