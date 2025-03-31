<?php
require_once 'utilesGenerales.php';
require_once 'login.php';

$opc = @$_POST['opc'] ?? @$_GET['opc'] ?? '';

switch ($opc) {
    case 'submitForm':
        enviaInfoDatabase();
        break;
    case 'getCategorias':
        getCategorias();
        break;
    case 'getSubcategoria':
        getSubcategoria();
        break;
    case 'getEtiquetasGenerales':
        getEtiquetasGenerales();
        break;
    case 'getNombreSucursal':
        getNombreSucursal();
        break;
    case 'getTipoTarjetas':
        getTipoTarjetas();
        break;
    case 'fillTableSearch':
        fillTableSearch();
        break;
    case 'getInfoRegistro':
        getInfoRegistro();
        break;
    case 'updateForm':
        updateForm();
        break;
    case 'getEstatusBoCat':
        getEstatusBoCat();
        break;
    case 'getBitacoraBancoppel':
        getBitacoraBancoppel();
        break;
    case 'login':
        login();
        break;
    case 'signUp':
        signUp();
        break;
    case 'getSessionInfo':
        getSessionInfo();
        break;
    case 'changePassword':
        changePassword();
        break;
    case 'setTableRoles':
        setTableRoles();
        break;
    case 'saveNewRoles':
        saveNewRoles();
        break;
    case 'setTableDeleteUsers':
        setTableDeleteUsers();
        break;
    case 'removeUser':
        removeUser();
        break;
    case 'formUpdatePass':
        formUpdatePass();
        break;
    default:
        echo json_encode(['estado' => false, 'mensaje' => '404 not found']);
        exit;
}

function enviaInfoDatabase(){

    $estado = false;
    $mensaje = '';

    $tableName = @$_POST['tableName'];
    
    try{

        $conn = getConnection();

        creaTablas();

        $data = json_decode( $_POST['obj'], true);

        $session = getSessionCurrentUser();
        $dataEmpleado = getInfoEmpleado( $session['username'] );

        $data['fecha_llamada'] = date('Y-m-d');
        $data['fecha_insercion'] = date('Y-m-d H:i:s');

        $structureTable = getStructureTable( $tableName );
        if( in_array( 'agente_numero' , $structureTable ) ) $data['agente_numero'] = $session['username'];
        if( in_array( 'agente_zona' , $structureTable ) ) $data['agente_zona'] = $dataEmpleado['zona'];
        if( in_array( 'agente_jefe' , $structureTable ) ) $data['agente_jefe'] = $dataEmpleado['jefe'];

        if( !@pg_insert(
            $conn,
            $tableName,
            $data,
            PGSQL_DML_EXEC
        )) throw new Exception("Error al guardar la informacion");

        pg_close($conn);
        
        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    } 

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje);
    echo json_encode($salidaJson);
}

function updateForm(){

    $estado = false;
    $mensaje = '';

    $tableName = $_POST['tableName'];
    $folio_uuid = $_POST['folio_uuid'];
    
    $data = json_decode( $_POST['obj'], true);
    $arrCondition = [ 'folio_uuid' => $folio_uuid ];
    
    try{

        $conn = getConnection();

        $session = getSessionCurrentUser();

        if( !validUser( ['CONSULTOR'] ) ) throw new Exception('El usuario no tiene permisos para actualizar registros');

        $structureTable = getStructureTable( $tableName );
        if( in_array( 'dias_dilacion' , $structureTable ) ) $data['dias_dilacion'] = setDiasDilacion( $tableName, $folio_uuid );
        
 
        if( !pg_update(
            $conn,
            $tableName,
            $data,
            $arrCondition,
            PGSQL_DML_EXEC)
        ) throw new Exception("Error al actualizar el registro con folio {$folio_uuid}");

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje);
    echo json_encode( $salidaJson );
}

function getEtiquetasGenerales(){

    $estado = false;
    $mensaje = '';
    $datos = [];

    try{

        $conn = getConnection();
        if( !$conn ) throw new Exception('Error en la conexion');

        $sQuery = "SELECT nombre_etiqueta FROM etiqueta_general";
        $result = @pg_query($conn, $sQuery);

        if( !$result ) throw new Exception('Error al obtener los estados');

        $datos = pg_fetch_all($result, PGSQL_ASSOC);

        pg_close($conn);

        $estado= true;
        
    }catch(Exception $e){
        $mensaje= $e->getMessage();
    }
    
    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode($salidaJson);

    

}

function getTipoTarjetas(){

    $estado = false;
    $mensaje = '';
    
    $htmlResp = "<option value=''>SELECCIONE</option>";

    try{

        $conn = getConnection();
        $sQuery = "SELECT tipo_tarjeta FROM bitacora_bancoppel_catalogo_tipo_tarjetas ORDER BY 1;";

        if(!$result = @pg_query($conn, $sQuery)) throw new Exception('Error al obtener los tipos de tarjeta');

        while($row = pg_fetch_assoc($result)){
            $htmlResp .= "<option value='{$row['tipo_tarjeta']}'>{$row['tipo_tarjeta']}</option>";
        }
        
        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $htmlResp);
    echo json_encode( $salidaJson );
}

function getCategorias(){

    $estado = false;
    $mensaje = '';
    
    $htmlResp = "<option value=''>SELECCIONE</option>";

    try{

        $conn = getConnection();
        $sQuery = "SELECT DISTINCT categoria FROM bitacora_bancoppel_catalogo_categorias ORDER BY 1;";

        if(!$result = @pg_query($conn, $sQuery)) throw new Exception('Error al obtener los tipos de tarjeta');

        while($row = pg_fetch_assoc($result)){
            $htmlResp .= "<option value='{$row['categoria']}'>{$row['categoria']}</option>";
        }
        
        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $htmlResp);
    echo json_encode( $salidaJson );
}

function getSubcategoria(){

    $estado = false;
    $mensaje = '';
    
    $htmlResp = "<option value=''>SELECCIONE</option>";

    try{

        $categoria = @$_GET['categoria'] ?? '';

        $conn = getConnection();
        $sQuery = "SELECT subcategoria FROM bitacora_bancoppel_catalogo_categorias WHERE categoria = '$categoria' ORDER BY 1;";

        if(!$result = @pg_query($conn, $sQuery)) throw new Exception('Error al obtener los tipos de tarjeta');

        while($row = pg_fetch_assoc($result)){
            $htmlResp .= "<option value='{$row['subcategoria']}'>{$row['subcategoria']}</option>";
        }
        
        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $htmlResp);
    echo json_encode( $salidaJson );
}

function getEstatusBoCat(){

    $estado = false;
    $mensaje = '';

    $datos = "<option value=''>SELECCIONE</option>";

    try{

        $conn = getConnection();

        $sQuery = "SELECT estatus FROM bitacora_bancoppel_catalogo_estatus_bo_cat ORDER BY 1;";

        if( !$result = @pg_query($conn, $sQuery) ) throw new Exception('Error la obtenera los estatus para BO');

        while($row = pg_fetch_assoc($result)){
            $datos .= "<option value='{$row['estatus']}'>{$row['estatus']}</option>";
        }

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode( $salidaJson );
}



function fillTableSearch(){

    $estado = false;
    $mensaje = '';
    $datos = '<tr><td colspan="4">No se encontraron datos</td></tr>';

    $tableName = $_POST['tableName'];
    $tableName = sanitizedString( $tableName );

    $strCondition = getConditionSearchRow();
    
    try{
        $conn = getConnection();

        $sQuery = "SELECT num_caso,
                        numero_cliente,
                        descripcion_queja,
                        fecha_insercion::DATE as fecha,
                        folio_uuid
                    FROM {$tableName} WHERE {$strCondition} ORDER BY fecha_insercion DESC LIMIT 10;";

        if( !$result = @pg_query($conn, $sQuery) ) throw new Exception("Error al consultar la tabla {$tableName}");

        if( pg_num_rows($result) > 0) $datos = '';
        
        while($row = pg_fetch_assoc($result)){

                $datos .= "
                    <tr data-folio-uuid='{$row['folio_uuid']}'>
                        <td>{$row['num_caso']}</td>
                        <td>{$row['numero_cliente']}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$row['descripcion_queja']}</td>
                    </tr>
                ";

        }

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode( $salidaJson );
}

function getConditionSearchRow(){

    $num_caso = @$_POST['num_caso'];
    $num_cte = @$_POST['num_cte'];
    $fecha = @$_POST['fecha'];
    
    $arrCondition = [];

    if( $num_caso && filter_var($num_caso, FILTER_VALIDATE_INT) ){
        $arrCondition[] = "num_caso = {$num_caso}";
    }
    if( $num_cte ){
        $num_cte = sanitizedString( $num_cte );
        $arrCondition[] = "numero_cliente = '{$num_cte}'";
    }
    if( $fecha && DateTime::createFromFormat('Y-m-d', $fecha) ){
        $arrCondition[] = "fecha_insercion::DATE = '{$fecha}'";
    }
    
    if( count($arrCondition) > 0 ){
        $strCondition = implode(' and ', $arrCondition);
    }else{
        $strCondition = 'true';
    }

    return $strCondition;
}

function getInfoRegistro(){

    $tableName = @$_POST['tableName'];
    $folio_uuid = @$_POST['folio_uuid'];

    $estado = false;
    $mensaje = '';
    $datos = [];

    try{

        $conn = getConnection();

        if(
            !$result = @pg_select(
                $conn,
                $tableName,
                ['folio_uuid' => $folio_uuid],
                PGSQL_CONV_FORCE_NULL,
                PGSQL_ASSOC
            )
        ) throw new Exception("No se encontro informacion sobre el folio: '{$folio_uuid}'");

        $datos = $result[0];
        $datos = array_filter($datos);
        
        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode( $salidaJson );
}





function creaTablas(){

    $conn = getConnection();
    $sQuery = "SELECT fn_creatablas_bitacora_bancoppel();";

    if( !@pg_query($conn, $sQuery) ) throw new Exception('Error al crear las tablas');
    
    return true;
}

function getBitacoraBancoppel(){

    $estado = false;
    $mensaje = '';
    $datos = [];

    try{
        $sQuery = "SELECT nombre_bitacora as bitacora FROM bitacora_bancoppel_catalogo_tablas";

        $conn = getConnection();
        if( !$result = @pg_query($conn, $sQuery) ) throw new Exception('Error al obtener los nombres de las bitacoras');

        $datos = pg_fetch_all($result, PGSQL_ASSOC);

        pg_close($conn);
        
        $estado= true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }
    
    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode($salidaJson);
}

function getStructureTable( $tableName ){
    
    $resp = [];
    $conn = getConnection();
    
    $sQuery = "SELECT table_name, column_name, ordinal_position
                FROM information_schema.columns
                WHERE table_name = '{$tableName}'
                ORDER BY ordinal_position;";

    $result = @pg_query($conn, $sQuery);
    if( pg_last_error($conn) ) throw new Exception('Error al obtener la estructura de la tabla');

    while($row = pg_fetch_assoc($result)){
        $resp[] = $row['column_name'];
    }

    return $resp;
}

function setDiasDilacion( $tableName, $folio_uuid ){

    $conn = getConnection();
    $sQuery = "SELECT fecha_insercion FROM {$tableName} WHERE folio_uuid = '$folio_uuid';";

    $result = @pg_query($conn, $sQuery);
    if( pg_last_error($conn) ) throw new Exception('Error al obtener la fecha del registro para calcular los dias de dilacion');
    $row = pg_fetch_assoc($result);

    $inicio = date_create( $row['fecha_insercion'] );
    $fin = date_create();
    $diferencia = date_diff($inicio, $fin);

    return $diferencia->format('%a');
}



function login(){

    $estado = false;
    $mensaje = '';

    $username = $_POST['num_empleado'];
    $pass = $_POST['password'];

    try{

        if( !validateUser($username,$pass) ) throw new Exception('Usuario o contraseña no coinciden');
            
        $userId = getUserByUsername( $username )['id'];

        createSession( $userId );

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje);
    echo json_encode( $salidaJson );
}

function signUp(){


    $estado = false;
    $mensaje = '';

    $username = $_POST['num_empleado'];
    $nombre = $_POST['nombre_empleado'];
    $pass = $_POST['password'];

    try{

        if( !userExistsInCatalogoEmpleados( $username ) ) throw new Exception('El usuario no existe en el catalogo de empleados');

        $userId = createUser($username, $nombre, 'AGENTE', $pass);

        createSession( $userId );

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje);
    echo json_encode($salidaJson);
}


function userExistsInCatalogoEmpleados( $numempleado ){

    if( !filter_var($numempleado, FILTER_VALIDATE_INT) ) throw new Exception('El username debe ser de tipo entero');

    $conn = getConnection();
    $sQuery = "SELECT true as empleado_existe FROM catalogo_empleados_atn WHERE empleado = {$numempleado};";

    $result = @pg_query($conn, $sQuery);
    if( pg_last_error($conn) ) throw new Exception('Error al obtener la informacion del empleado');

    return boolval( pg_num_rows($result) );
}

function getInfoEmpleado( $numempleado ){

    if( !userExistsInCatalogoEmpleados( $numempleado ) ) throw new Exception('El usuario no se encuentra registrado en el catalogo de empleados');
    if( !filter_var($numempleado, FILTER_VALIDATE_INT) ) throw new Exception('El usuario debe ser de tipo entero');

    $conn = getConnection();
    $sQuery = "SELECT empleado, nombre, centro, jefe, nombrejefe,
                    gerentetitular as gerente, nombregerentetitular gerentetitular,
                    gerentezona zona, nombregerentezona as gerentezona
                FROM catalogo_empleados_atn WHERE empleado = $numempleado;";

    $result = @pg_query($conn, $sQuery);
    if( pg_last_error($conn) ) throw new Exception("Error al obtener la informacion del usuario {$numempleado}");
    if( pg_num_rows($result) ) throw new Exception("No se encontró al usuario {$numempleado}");

    return pg_fetch_assoc($result);

}


function getSessionInfo(){

    $estado = false;
    $mensaje = '';
    $datos = [];

    try{
        $session = getSessionCurrentUser();

        $datos = [
            'id' => $session['userId'],
            'rol' => $session['rolType'],
            'nombre' => $session['nombre'],
            'empleado' => $session['username']
        ];

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }
    
    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode( $salidaJson );
}

function changePassword(){

    $estado = false;
    $mensaje = '';
    
    try{
        
        if( !$oldPass = @$_POST['old_password'] ) throw new Exception('Verifique la contraseña anterior sea un valor valido');
        if( !$newPass = @$_POST['new_password'] ) throw new Exception('Verifique la nueva contraseña sea un valor valido');

        $session = getSessionCurrentUser();
        
        if( !validateUserById($session['userId'], $oldPass) ) throw new Exception('Las credenciales no coinciden');

        if( $oldPass !== $newPass ) updatePassword( $session['userId'], $oldPass, $newPass );
        if( isset( $_POST['nombre'] ) && $_POST['nombre'] ) updateUserWithoutPass( $session['userId'],  [ 'nombre' => $_POST['nombre'] ] );

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje);
    echo json_encode( $salidaJson );
}


function setTableRoles(){

    $estado = false;
    $mensaje = '';
    $datos = '';

    try{
        
        $users = getAllUsers();
        foreach($users as $user){

            $setNotif = fn($e) => strtoupper( $user['roltype'] ) == strtoupper($e) ? "data-notification='!'" : null;
            $setChecked = fn($e) => strtoupper( $user['roltype'] ) == strtoupper($e) ? "checked" : null;
            
            $radioName = bin2hex(random_bytes(15));

            $datos .= "
                <tr data-userid='{$user['userid']}'>
                    <td>{$user['username']}</td>
                    <td>{$user['nombre']}</td>
                    <td>
                        <div class='tabs'>
                            <label class='tab' title='Agente' {$setNotif('AGENTE')}>
                                <input type='radio' value='AGENTE' name='{$radioName}' {$setChecked('AGENTE')}>
                                <svg width='20px' height='20px' viewBox='0 0 48 48'><g fill='currentColor'><path d='M20.404 22.202a1.8 1.8 0 1 0 0-3.601a1.8 1.8 0 0 0 0 3.601' /><path fillRule='evenodd' d='M11.41 30.008V42h17.112v-6.512h4.293c.268 0 .524-.053.757-.148l-2.38-1.852h-4.67V40H13.409V29.202l-.56-.581C11.209 26.916 8 22.931 8 17.975c0-1.63.615-4.126 2.466-6.19c1.633-1.821 4.373-3.465 8.937-3.743v7.05a5.4 5.4 0 1 0 4.058 9.76l14.07 10.923a2.25 2.25 0 1 0 1.183-1.614L24.88 23.42a5.402 5.402 0 0 0-3.477-8.329V8.006c2.543.047 4.305.388 5.638.888c1.412.53 2.459 1.28 3.514 2.257l.142.132c1.034.958 1.342 1.244 1.517 1.71l4.233 11.27h-3.632v2.888l2 1.555v-2.443h1.632a1.998 1.998 0 0 0 1.873-2.701l-4.234-11.273c-.349-.93-1.024-1.55-1.874-2.33l-.297-.274C29.55 7.492 26.859 6 20.798 6C9.006 6 6 13.875 6 17.975c0 5.767 3.683 10.241 5.41 12.033m8.993-6.207a3.4 3.4 0 1 0 .001-6.802a3.4 3.4 0 0 0 0 6.802' clipRule='evenodd' /></g></svg>
                            </label>
                            
                            <label class='tab' title='Consultor' {$setNotif('CONSULTOR')}>
                                <input type='radio' value='CONSULTOR' name='{$radioName}' {$setChecked('CONSULTOR')}>
                                <svg width='1.13em' height='1em' viewBox='0 0 576 512'><path fill='currentColor' d='M288 144a111 111 0 0 0-31.24 5a55.4 55.4 0 0 1 7.24 27a56 56 0 0 1-56 56a55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144m284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19M288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400' /></svg>
                            </label>

                            <label class='tab' title='Administrador' {$setNotif('ADMIN')}>
                                <input type='radio' value='ADMIN' name='{$radioName}' {$setChecked('ADMIN')}>
                                <svg width='20px' height='20px' viewBox='0 0 24 25'><path fill='currentColor' d='M4.253 5.397a1.492 1.492 0 0 0 2.23-1.288h1.5a1.492 1.492 0 0 0 2.231 1.288l.75 1.298c.417-.233.916-.387 1.424-.478q-.046-.135-.12-.264l-.759-1.313a1.49 1.49 0 0 0-2.025-.553A1.49 1.49 0 0 0 7.992 2.61H6.476c-.82 0-1.485.66-1.492 1.478a1.49 1.49 0 0 0-2.026.553L2.2 5.953c-.41.71-.17 1.616.534 2.031a1.49 1.49 0 0 0-.534 2.031l.758 1.313c.41.71 1.314.955 2.026.553c.006.618.388 1.147.928 1.368c-.003-.571.14-1.15.447-1.68l.068-.118a1.494 1.494 0 0 0-2.174-.88l-.75-1.299c.985-.576.985-2 0-2.576z'/><path fill='currentColor' d='M7.234 9.484a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3'/><path fill='currentColor' fillRule='evenodd' d='M11.64 15.11a3.065 3.065 0 1 1 6.13 0a3.065 3.065 0 0 1-6.13 0m3.066-1.564a1.565 1.565 0 1 0 0 3.13a1.565 1.565 0 0 0 0-3.13' clipRule='evenodd'/><path fill='currentColor' fillRule='evenodd' d='M7.658 17.903a1.833 1.833 0 0 1 .671-2.505a.333.333 0 0 0 0-.576a1.833 1.833 0 0 1-.67-2.504l1.106-1.916a1.833 1.833 0 0 1 2.503-.67a.332.332 0 0 0 .499-.288c0-1.012.82-1.833 1.832-1.833h2.213c1.013 0 1.833.821 1.833 1.833c0 .256.277.416.498.288a1.83 1.83 0 0 1 2.503.67l1.107 1.918a1.83 1.83 0 0 1-.67 2.502a.332.332 0 0 0 0 .576a1.833 1.833 0 0 1 .67 2.503l-1.105 1.916a1.833 1.833 0 0 1-2.504.671a.333.333 0 0 0-.5.288c0 1.013-.82 1.833-1.832 1.833H13.6a1.833 1.833 0 0 1-1.833-1.832a.333.333 0 0 0-.5-.288a1.833 1.833 0 0 1-2.503-.671zm1.421-1.206a.333.333 0 0 0-.122.456l1.106 1.915c.092.16.295.214.455.122c1.221-.705 2.749.176 2.749 1.587c0 .183.149.332.333.332h2.212a.333.333 0 0 0 .333-.333c0-1.41 1.527-2.292 2.749-1.587c.16.092.363.037.455-.122l1.106-1.916a.333.333 0 0 0-.122-.454c-1.221-.705-1.222-2.468 0-3.174a.33.33 0 0 0 .121-.453l-1.107-1.917a.33.33 0 0 0-.454-.122c-1.221.706-2.748-.177-2.748-1.587a.333.333 0 0 0-.333-.333H13.6a.33.33 0 0 0-.332.333c0 1.41-1.527 2.292-2.749 1.586a.333.333 0 0 0-.454.122l-1.106 1.916a.333.333 0 0 0 .122.455c1.222.705 1.22 2.47 0 3.174' clipRule='evenodd'/></svg>
                            </label>
                            <span class='glider'></span>
                        </div>
                    </td>
                </tr>
            ";
        }

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode( $salidaJson );
}

function saveNewRoles(){

    $estado = false;
    $mensaje = '';

    try{

        $conn = getConnection();

        $users = json_decode( $_POST['users'], true );

        foreach( $users as $user ){

            $updateData = [ 'roltype' => $user['newRole'] ];
            updateUserWithoutPass($user['userId'], $updateData);

        }

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje);
    echo json_encode( $salidaJson );
}

function setTableDeleteUsers(){

    $estado = false;
    $mensaje = '';
    $datos = '';

    try{
        
        $users = getAllUsers();
        foreach($users as $user){
            
            $datos .= "
                <tr data-userid='{$user['userid']}'>
                    <td>{$user['username']}</td>
                    <td>{$user['nombre']}</td>
                    <td>
                        <svg class='svg-delete' width='20px' height='20px' viewBox='0 0 14 14'><path fill='none' stroke='currentColor' strokeLinecap='round' strokeLinejoin='round' d='m11.5 5.5l-1 8h-7l-1-8M1 3.5h12m-8.54-.29V1.48a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v2'/></svg>
                    </td>
                </tr>
            ";
        }

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje, 'datos' => $datos);
    echo json_encode( $salidaJson );
}

function removeUser(){

    $estado = false;
    $mensaje = '';

    try{

        deleteUser( $_POST['userId'] );

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje' => $mensaje);
    echo json_encode( $salidaJson );
}

function formUpdatePass(){

    $estado = false;
    $mensaje = '';

    try{

        if( 
            !@$_POST['username'] ||
            !@$_POST['old_password'] ||
            !@$_POST['new_password']
        ) throw new Exception('Faltan campos por enviar');
        
        $username = $_POST['username'];
        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];

        $userData = getUserByUsername( $username );
        updatePassword( $userData['id'], $old_pass, $new_pass );
        createSession( $userData['id'] );

        $estado = true;
    }catch(Exception $e){
        $mensaje = $e->getMessage();
    }

    $salidaJson = array('estado' => $estado, 'mensaje'=> $mensaje);
    echo json_encode( $salidaJson );
}