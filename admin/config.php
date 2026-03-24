<?php

function env($key, $default = null) {
    $v = getenv($key);
    return $v !== false ? $v : $default;
}

define('DB_HOST', env('ANAPEACE_DB_HOST', '127.0.0.1'));
define('DB_NAME', env('ANAPEACE_DB_NAME', 'divine_confidence'));
define('DB_USER', env('ANAPEACE_DB_USER', 'root'));
define('DB_PASS', env('ANAPEACE_DB_PASS', 'linux'));

define('UPLOAD_DIR', __DIR__ . '/../uploads');

if (!is_dir(UPLOAD_DIR)) {
    @mkdir(UPLOAD_DIR, 0775, true);
}

if (!is_dir(UPLOAD_DIR . '/gallery')) {
    @mkdir(UPLOAD_DIR . '/gallery', 0775, true);
}

// Assets upload dirs
$assetUpload = __DIR__ . '/../assets/upload';

if (!is_dir($assetUpload)) {
    @mkdir($assetUpload, 0775, true);
}

@chmod($assetUpload, 0775);
if (!is_writable($assetUpload)) {
    @chmod($assetUpload, 0777);
}

$assetSocial = $assetUpload . '/social';

if (!is_dir($assetSocial)) {
    @mkdir($assetSocial, 0775, true);
}

@chmod($assetSocial, 0775);
if (!is_writable($assetSocial)) {
    @chmod($assetSocial, 0777);
}
