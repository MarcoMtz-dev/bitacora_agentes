<?php
require_once 'useEnv.php';

function getConnection(){
      $server = $_ENV['DATABASE_SERVER'];
      $user = $_ENV['DATABASE_USER'];
      $pass = $_ENV['DATABASE_PASS'];
      $bd = $_ENV['DATABASE_NAME'];
      $connec = @pg_connect("host=$server dbname=$bd user=$user password=$pass") or throw new Exception('Error de conexion con la base de datos');
      return $connec;
}

?>