<?php


/**
 * Add routes
 * 
 * @param  string $route example: 
 *                          to "/_route/web/home.route.php",
 *                          lets, "web/home"
 *
 * @return null
 */
if (!function_exists('addRoute')) {
    function addRoute($route)
    {
        $file = explode('/', $route);
        require_once  base_path("routes/_routes/$file[0]/$file[1].route.php");
    }
}


if (!function_exists('vd')) {
    function vd(...$vars)
    {
        var_dump(...$vars);
        exit;
    }
}
