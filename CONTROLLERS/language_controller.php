<?php
session_start();
$lang = $_GET['lang'] ?? 'ca';
if (in_array($lang, ['ca', 'en'], true)) {
    $_SESSION['LANG_APP'] = $lang;
}
// Only allow internal navigation; never redirect to another domain.
$referer = $_SERVER['HTTP_REFERER'] ?? '/index.php';
$path = parse_url($referer, PHP_URL_PATH);
$query = parse_url($referer, PHP_URL_QUERY);
$target = (is_string($path) && str_starts_with($path, '/') && !str_starts_with($path, '//')) ? $path : '/index.php';
if (is_string($query) && $query !== '') { $target .= '?' . $query; }
header('Location: ' . $target);
exit;
