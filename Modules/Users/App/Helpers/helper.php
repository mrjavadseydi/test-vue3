<?php
if (!function_exists('allowed_roles')) {
    function allowed_roles()
    {
        if (auth()->user()->role == 'operator') {
            return ['customer', 'operator'];
        } elseif(auth()->user()->role == 'admin') {
            return ['admin', 'customer', 'operator'];
        }else{
            return [];
        }
    }
}
