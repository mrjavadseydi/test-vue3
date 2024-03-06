<?php
if (!function_exists('allowed_roles')) {
    function allowed_roles()
    {
        if (auth()->user()->role == 'operator') {
            return ['user', 'operator'];
        } elseif(auth()->user()->role == 'admin') {
            return ['admin', 'user', 'operator'];
        }else{
            return [];
        }
    }
}
