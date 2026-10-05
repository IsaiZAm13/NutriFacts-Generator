<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok'=>false,'message'=>'Método no permitido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['ok'=>false,'message'=>'JSON inválido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$nombre = trim((string)($data['nombre'] ?? ''));
$codigo = trim((string)($data['codigo_barras'] ?? ''));
$icono = 'image.php?code=' . rawurlencode($codigo);

if ($nombre === '' || $codigo === '') {
    http_response_code(422);
    echo json_encode(['ok'=>false,'message'=>'Nombre y código de barras son obligatorios.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match('/^[0-9]+$/', $codigo)) {
    http_response_code(422);
    echo json_encode(['ok'=>false,'message'=>'El código de barras debe contener solo números.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$file = __DIR__ . DIRECTORY_SEPARATOR . 'labels.json';

$labels = [];
if (is_file($file)) {
    $existing = json_decode(file_get_contents($file), true);
    if (is_array($existing)) {
        $labels = $existing;
    }
}

/*
 * Estructura mínima añadida:
 * {
 *   "nombre": "...",
 *   "codigo_barras": "..."
 * }
 *
 * Si ya existe el código de barras, se actualiza ese registro.
 */
$updated = false;
foreach ($labels as $i => $item) {
    if (is_array($item) && (string)($item['codigo_barras'] ?? '') === $codigo) {
        $labels[$i]['nombre'] = $nombre;
        $labels[$i]['codigo_barras'] = $codigo;
        $labels[$i]['icono'] = $icono;
        $updated = true;
        break;
    }
}

if (!$updated) {
    $labels[] = [
        'nombre' => $nombre,
        'codigo_barras' => $codigo,
        'icono' => $icono
    ];
}

$json = json_encode($labels, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

if ($json === false || file_put_contents($file, $json . PHP_EOL, LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode(['ok'=>false,'message'=>'No se pudo escribir labels.json. Verifica permisos.'], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'ok'=>true,
    'message'=>$updated ? 'Registro actualizado.' : 'Registro agregado.',
    'nombre'=>$nombre,
    'codigo_barras'=>$codigo,
    'icono'=>$icono
], JSON_UNESCAPED_UNICODE);
?>
