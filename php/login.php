<?php
require_once 'utilesGenerales.php';


function getUserById($userId){
    
    if( !isUuid( $userId ) ) throw new Exception('userId is not valid');
    
    $conn = getConnection();
    $sQuery = "SELECT id, username, nombre_empleado as nombre, roltype FROM bitacora_bancoppel_usuarios WHERE id = '{$userId}';";
    
    $result = @pg_query($conn, $sQuery);
    if( pg_last_error($conn) ) throw new Exception("Error al obtener el empleado '{$userId}'");
    if( pg_num_rows($result) < 1 ) throw new Exception('Usuario no encontrado');

    return pg_fetch_assoc($result);
}

function getUserByUsername($username){
    
    $username = filter_var($username, FILTER_SANITIZE_NUMBER_INT);

    $conn = getConnection();
    $sQuery = "SELECT id, username, nombre_empleado as nombre, roltype from bitacora_bancoppel_usuarios where username='{$username}';";

    $result = @pg_query($conn, $sQuery);
    if( pg_last_error($conn) ) throw new Exception("Error al obtener el empleado '{$username}'");
    if( pg_num_rows($result) < 1 ) throw new Exception('Usuario no encontrado');

    return pg_fetch_assoc($result);
}

function validateUser($username, $pass){
   
    $conn = getConnection();

    $username = filter_var($username, FILTER_SANITIZE_NUMBER_INT);
    $sQuery = "SELECT password as pass FROM bitacora_bancoppel_usuarios WHERE username = '{$username}';";

    if (!$result = @pg_query($conn, $sQuery)) throw new Exception('Ocurrió un error mientras se validaban las credenciales');
    if (pg_num_rows($result) < 1) throw new Exception('Usuario no encontrado');

    $userPass = pg_fetch_assoc($result)['pass'];

    return check_pass($pass, $userPass);
}

function validateUserById($userId, $pass){
    
    $conn = getConnection();
    $sQuery = "SELECT password as pass FROM bitacora_bancoppel_usuarios WHERE id = '{$userId}';";

    if (!isUuid( $userId ) ) throw new Exception('El usuario proporcionado no es un usuario valido');
    if (!$result = @pg_query($conn, $sQuery)) throw new Exception('Ocurrió un error mientras se validaban las credenciales');
    if (pg_num_rows($result) < 1) throw new Exception('Usuario no encontrado');

    $userPass = pg_fetch_assoc($result)['pass'];
    return check_pass($pass, $userPass);
}

function checkUserExists($username){

    $userExists = false;

    $empleado = filter_var($username, FILTER_SANITIZE_NUMBER_INT);

    $conn = getConnection();
    $sQuery = "SELECT true as exists FROM bitacora_bancoppel_usuarios WHERE username = '$empleado';";

    if(!$result = @pg_query($conn, $sQuery)) throw new Exception("Error al consultar el username {$username}");

    return boolval( pg_num_rows($result) );
}

function createSession( $userId ){
    
    if (needUpdatePass($userId) ) throw new Exception('Es necesario actualizar la contraseña');

    $data = getUserById( $userId );

    session_start();
    $_SESSION['userId'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['nombre'] = $data['nombre'];
    $_SESSION['rolType'] = $data['roltype'];

    return true;
}

function getSessionCurrentUser(){
    session_start();
    return $_SESSION;
}


function createUser($username, $nombre, $rolType, $pass){

    $conn = getConnection();
        
    $nombre = sanitizedString( $nombre );
    $rolType = sanitizedString( $rolType );

    if( !filter_var($username, FILTER_VALIDATE_INT) ) throw new Exception('El username debe ser de tipo entero');
    if( checkUserExists( $username ) ) throw new Exception('El usuario ingresado ya existe');
    if( !validPassword($pass) ) throw new Exception('La contraseña no coincide con las politicas SGSI');
    
    $passDefault = hash_pass( $pass );
    $fechaActual = date('Y-m-d');

    $sQuery = "INSERT INTO bitacora_bancoppel_usuarios
                (username, nombre_empleado, roltype, password, last_update)
                VALUES ($username, '$nombre', '$rolType', '$passDefault', '$fechaActual') RETURNING id;";

    if( !$result = @pg_query($conn, $sQuery) ) throw new Exception('Error al registrar al usuario');

    $userId = pg_fetch_assoc($result)['id'];

    return $userId ?: false;
}

function updatePassword($userId, $old_pass, $new_pass){

    $conn = getConnection();

    if( !validateUserById($userId, $old_pass) ) throw new Exception('El usuario o la contraseña no coinciden');
    if( $old_pass === $new_pass ) throw new Exception('La nueva contraseña no puede ser identica a la anterior');
    if( !validPassword( $new_pass ) ) throw new Exception('La contraseña propuesta no cumple con los requisitos del SGSI');

    $arrData = [
        'password' => hash_pass( $new_pass ),
        'last_update' => date('Y-m-d')
    ];
    $arrCondition = [
        'id' => $userId
    ];

    
    if( !@pg_update(
        $conn,
        'bitacora_bancoppel_usuarios',
        $arrData,
        $arrCondition,
        PGSQL_DML_EXEC
    ) ) throw new Exception('Error al actualizar la contraseña del usuario');

    return true;
}

function updateUserWithoutPass($userId, $updateData){

    $conn = getConnection();

    $updateData['nombre'] = sanitizedString( @$updateData['nombre'] );
    $updateData['roltype'] = sanitizedString( @$updateData['roltype'] );

    if( $updateData['roltype'] && !isValidRole( @$updateData['roltype'] ) ) throw new Exception('El nuevo rol no es valido');

    $arrData = array_filter([
        'nombre_empleado' => @$updateData['nombre'],
        'roltype' => @$updateData['roltype']
    ]);

    $arrCondition = [
        'id' => $userId
    ];

    if( !@pg_update(
        $conn,
        'bitacora_bancoppel_usuarios',
        $arrData,
        $arrCondition,
        PGSQL_DML_EXEC
    ) ) throw new Exception('Error al actualizar la informacion del usuario');

    return true;

}

function deleteUser( $userId ){

    $conn = getConnection();

    if( !isUuid( $userId ) ) throw new Exception('userId is not valid');

    $sQuery = "DELETE FROM bitacora_bancoppel_usuarios WHERE id = '{$userId}';";

    if( !@pg_query( $conn, $sQuery ) ) throw new Exception("Error al eliminar el usuario {$userId}");
    
    return true;
}

function getAllUsers(){
   
    $conn = getConnection();
    $sQuery = "SELECT id as userid, username, nombre_empleado as nombre, roltype
                FROM bitacora_bancoppel_usuarios
                ORDER BY username, id;";

    $result = @pg_query($conn, $sQuery);
    if( pg_last_error($conn) ) throw new Exception("Error al consultar el username {$username}");

    return pg_fetch_all( $result );
}


function isUuid($str){
    $regex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';
    return preg_match($regex, $str);
}

function check_pass($pass, $hashedPass){
    return password_verify($pass, $hashedPass);
}

function hash_pass($pass){
    return password_hash($pass, PASSWORD_BCRYPT);
}


function validPassword(String $str){
    $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$#"!+*&%,])(?!.*\s).{15,}$/';
    return preg_match($regex, $str);
}

function validUser(Array $validSessions){
    @session_start();
    return in_array( strtoupper( $_SESSION['rolType'] ), $validSessions );
}

function isValidRole($rol){
    return in_array( $rol, ['AGENTE','CONSULTOR','ADMIN']);
}

function needUpdatePass( $userId ){

    $conn = getConnection();
    $sQuery = "SELECT
                    CURRENT_DATE - (last_update + '90 days'::interval)::DATE > 0 as pass_ok
                FROM bitacora_bancoppel_usuarios
                WHERE id = '{$userId}';";

    if( !isUuid( $userId ) ) throw new Exception('El userId no es valido');
    if( !$result = pg_query($conn, $sQuery) ) throw new Exception('Usuario no encontrado');

    $row = pg_fetch_assoc($result);

    return $row['pass_ok'] === 't' ? true : false;
}