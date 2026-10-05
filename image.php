<?php
// Sirve las imágenes desde C:\xampp\htdocs\icons sin depender de que Apache
// exponga correctamente la carpeta /icons dentro del proyecto.
$iconDir = 'C:/xampp/htdocs/icons';
$code = trim((string)($_GET['code'] ?? ''));

if ($code === '' || !preg_match('/^[0-9]+$/', $code)) {
    http_response_code(400);
    exit('Código inválido');
}

$extensions = ['png','jpg','jpeg','webp','gif'];
$found = '';

// Primero busca por nombre exacto.
foreach ($extensions as $ext) {
    $candidate = $iconDir . '/' . $code . '.' . $ext;
    if (is_file($candidate)) { $found = $candidate; break; }
}

// Respaldo: búsqueda insensible a mayúsculas/minúsculas en Windows/Linux.
if ($found === '' && is_dir($iconDir)) {
    foreach (scandir($iconDir) as $file) {
        if ($file === '.' || $file === '..') continue;
        $full = $iconDir . '/' . $file;
        if (!is_file($full)) continue;
        $base = pathinfo($file, PATHINFO_FILENAME);
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if ($base === $code && in_array($ext, $extensions, true)) {
            $found = $full;
            break;
        }
    }
}

if ($found === '') {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit('No se encontró imagen para el código: ' . $code);
}

$mime = match (strtolower(pathinfo($found, PATHINFO_EXTENSION))) {
    'png' => 'image/png',
    'jpg', 'jpeg' => 'image/jpeg',
    'webp' => 'image/webp',
    'gif' => 'image/gif',
    default => 'application/octet-stream'
};

header('Content-Type: ' . $mime);
header('Cache-Control: public, max-age=3600');
readfile($found);
exit;
