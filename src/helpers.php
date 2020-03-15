<?php

if (!function_exists('parseToken')) {
    /**
     * @param string $bearerToken
     * @return string
     * Date: 2020/3/11 Time: 上午8:41
     */
    function parseToken($bearerToken = '')
    {
        $tokenPre = 'Bearer ';
        $bool = strpos($bearerToken, $tokenPre);
        if ($bool !== false && $bool == 0) {
            $bearerToken = substr($bearerToken, strlen($tokenPre));
        }

        return $bearerToken;
    }
}