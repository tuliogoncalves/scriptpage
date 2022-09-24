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


/**
 * Remove mask.
 *
 * @param  string $value value to clear
 * @param  mixed $others add others values to be removed.
 *
 * @return string
 */
function clearMask($value, Array $others = null)
{
    $clear = [
        '.', ',', '/', '-', '(', ')', '[', ']', ' ', '+'
    ];

    if (!is_null($others)) {
        if (!is_array($others)) {
            $outros = [$others];
        }
        $clear = array_merge($clear, $others);
    }

    return str_replace($clear, '', $value);
}
