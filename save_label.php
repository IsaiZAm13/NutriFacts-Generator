<?php
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['ok'=>false,'message'=>'Método no permitido']); exit; }
$nombre = trim($_POST['nombre'] ?? '');
$codigo = trim($_POST['codigo_barras'] ?? '');
if ($nombre === '' || $codigo === '') { http_response_code(400); echo json_encode(['ok'=>false,'message'=>'Falta nombre o código de barras']); exit; }
if (!isset($_FILES['pdf']) || $_FILES['pdf']['error'] !== UPLOAD_ERR_OK) { http_response_code(400); echo json_encode(['ok'=>false,'message'=>'No se recibió el PDF']); exit; }
$dir = __DIR__ . DIRECTORY_SEPARATOR . 'etiquetas';
if (!is_dir($dir) && !mkdir($dir, 0777, true)) { http_response_code(500); echo json_encode(['ok'=>false,'message'=>'No se pudo crear la carpeta etiquetas']); exit; }
$safe = preg_replace('/[^A-Za-z0-9._ -]/u', '_', $nombre);
$safe = trim(preg_replace('/\s+/', ' ', $safe));
if ($safe === '') $safe='nutrition-facts';
$filename=$safe.'.pdf';
$path=$dir.DIRECTORY_SEPARATOR.$filename;
if (!move_uploaded_file($_FILES['pdf']['tmp_name'],$path)) { http_response_code(500); echo json_encode(['ok'=>false,'message'=>'No se pudo guardar el PDF']); exit; }
$jsonFile=__DIR__.DIRECTORY_SEPARATOR.'labels.json';
$items=[];
if (is_file($jsonFile)) { $raw=file_get_contents($jsonFile); $items=json_decode($raw,true); if(!is_array($items)) $items=[]; }
$record=['nombre'=>$nombre,'codigo_barras'=>$codigo,'icono'=>'image.php?code='.rawurlencode($codigo)];
$found=false;
foreach($items as $i=>$item){
  if(isset($item['codigo_barras']) && (string)$item['codigo_barras']===$codigo){ $items[$i]=$record; $found=true; break; }
}
if(!$found) $items[]=$record;
file_put_contents($jsonFile,json_encode($items,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),LOCK_EX);
echo json_encode(['ok'=>true,'archivo'=>'etiquetas/'.$filename,'registro'=>$record],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
