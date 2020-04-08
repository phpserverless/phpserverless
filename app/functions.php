<?php

/**
 * Global event manager
 * @return \FastEventManager\EventManager
 */
function events()
{
    static $mgr = null;
    if (is_null($mgr)) {
        $mgr = new FastEventManager\EventManager();
    }
    return $mgr;
}

/**
 * Returns the top most (root, base) path of the application
 * @return string
 */
function basePath($path = '')
{
    $rootPath = dirname(__DIR__);
    if ($path == "") {
        return $rootPath;
    }
    return $rootPath . '/' . ltrim($path, '/');
}
/**
 * Returns the top most (root, base) URL of the application
 * @return string
 */
function baseUrl($path = '')
{
    $url = \Sinevia\Registry::get("URL_BASE");
    return $url . '/' . ltrim($path, '/');
}

function config($key, $default = null)
{
    static $config = null;

    // Is already read? No=>Read config
    if ($config == null) {
        $config = include __DIR__ . '/config.php';
    }

    $temp = $config;
    $path = explode(".", $key);

    foreach ($path as $key) {
        if (isset($temp[$key])) {
            $temp = $temp[$key];
            continue;
        }
        return $default;
    }

    return $temp;
}

/**
 * Returns a database instance
 * @return \Sinevia\SqlDb
 */
function db($connectionName = "default", $persistent = true)
{
    static $db = null;

    if (is_null($db) or $persistent == false) {
        if (is_null($db) == false) {
            $db->close();
        }

        $databases = \Sinevia\Registry::get('DB');
        if ($connectionName == "default") {
            $connectionName = $databases["default_connection"];
        }
        $connection = $databases["connections"][$connectionName] ?? null;
        if ($connection == null) {
            throw new RuntimeException("Connection with name '$connectionName' not found");
        }
        //dd($connection);

        $dbType = $connection['driver'] ?? '';
        $dbHost = $connection['host'] ?? '';
        $dbName = $connection['database'] ?? '';
        $dbUser = $connection['username'] ?? '';
        $dbPass = $connection['password'] ?? '';

        $db = new \Sinevia\SqlDb(array(
            'database_type' => $dbType,
            'database_host' => $dbHost,
            'database_name' => $dbName,
            'database_user' => $dbUser,
            'database_pass' => $dbPass,
        ));
    }

    return $db;
}
function dd($var)
{
    \Sinevia\Utils::alert($var);
    exit;
}

/**
 * Converts an image path to data URI
 * @return string
 */
function image2DataUri($imagePath)
{
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->file($imagePath);
    return 'data:' . $type . ';base64,' . base64_encode(file_get_contents($imagePath));
}

/**
 * Checks if this is a GET request
 * @return boolean
 */
function isGet()
{
    $isPost = strtolower($_SERVER['REQUEST_METHOD']) == "get" ? true : false;
    return $isPost;
}

/**
 * Checks if this is a POST request
 * @return boolean
 */
function isPost()
{
    $isPost = strtolower($_SERVER['REQUEST_METHOD']) == "post" ? true : false;
    return $isPost;
}

function req($name, $default = null, $functions = [])
{
    $value = (isset($_REQUEST[$name]) == false) ? $default : $_REQUEST[$name];
    foreach ($functions as $fn) {
        $value = $fn($value);
    }
    return $value;
}

function redirect($url)
{
    return "<meta http-equiv=\"refresh\" content=\"0;url=$url\">";
}

/**
 * Renders a template
 * @return string
 */
function ui($view, $vars = array(), $options = array())
{
    $ext = pathinfo($view, PATHINFO_EXTENSION);
    if ($ext == '') {
        $view .= '.phtml';
    }
    $template = basePath('app/views/' . ltrim($view, '/'));
    return \Sinevia\Template::fromFile($template, $vars, $options);
}

/**
 * Renders a Blade template
 * @return string
 */
function blade($view, $data = [])
{
    $blade = new \Jenssegers\Blade\Blade(basePath('views'), basePath('tmp/cache'));
    return $blade->render($view, $data);
}

/**
 * Joins multiple CSS files, and optionally minifies them
 * @return string
 */
function joinCss($styles, $options = [])
{
    $minify = $options['minify'] ?? 'no';
    $html = '';
    $html .= '<style>';
    foreach ($styles as $style) {
        $path = basePath('public/' . trim($style, '/'));
        // DEBUG: $html .= '/* '.$path.' */';
        if (file_exists($path)) {
            $contents = file_get_contents($path);
            //if ($minify == "yes") {
            //    $contents = ';' . \JSMin\JSMin::minify($contents);
            //}
            $html .= $contents;
        }
    }
    $html .= '</style>';
    return $html;
}

/**
 * Joins multiple JavaScript files, and optionally minifies them
 * @return string
 */
function joinScripts($scripts, $options = [])
{
    $minify = $options['minify'] ?? 'no';
    $html = '';
    $html .= '<script>';
    foreach ($scripts as $script) {
        $path = basePath('public/' . trim($script, '/'));
        if (file_exists($path)) {
            $contents = file_get_contents($path);
            if ($minify == "yes") {
                $contents = ';' . \JSMin\JSMin::minify($contents);
            }
            $html .= $contents;
        }
    }
    $html .= '</script>';
    return $html;
}
