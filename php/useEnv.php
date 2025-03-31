<?php
function setEnvs($archivo) {
  if ( !file_exists($archivo) ) return false;

  $lines = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;

    list($nombre, $valor) = explode('=', $line, 2);
    $nombre = trim($nombre);
    $valor = trim($valor);

    if (!array_key_exists($nombre, $_ENV)) {
      putenv("{$nombre}={$valor}");
      $_ENV[$nombre] = $valor;
      $_SERVER[$nombre] = $valor;
    }
  }
}

setEnvs( dirname( $_SERVER['DOCUMENT_ROOT'] ) . '/envs/Bitacora_Bancoppel/.env' );
?>