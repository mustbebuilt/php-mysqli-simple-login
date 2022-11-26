<?php
////////////////////// START SESSION HERE ///////////////////////////
////////////////// config cookie security ///////////////////////////
//session_set_cookie_params(
//    int $lifetime_or_options,
//    ?string $path = null,
//    ?string $domain = null,
//    ?bool $secure = null,
//    ?bool $httponly = null
//): bool
// for example session_set_cookie_params(0, '/myfolder', 'mydomain.org.uk/', 1, 1);
session_start();
?>