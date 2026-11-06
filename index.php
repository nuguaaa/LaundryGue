<?php

/**
 * Laravel - InfinityFree / Shared Hosting Root Front Controller Fallback
 * 
 * File ini bertindak sebagai jembatan jika project diunggah langsung ke folder htdocs
 * pada hosting InfinityFree / cPanel tanpa memisahkan folder public.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'
);

// Jika file aset fisik ada di dalam folder public, biarkan server menyajikannya
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// Arahkan penanganan permintaan ke front controller utama Laravel di folder public
require_once __DIR__ . '/public/index.php';
