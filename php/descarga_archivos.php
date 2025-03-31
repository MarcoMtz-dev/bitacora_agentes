<?php
require_once 'utilesGenerales.php';

if (isset($_GET['tabla']) && isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
    generarCSV($_GET['tabla'], $_GET['fechaInicio'], $_GET['fechaFin']);
}
else{
    http_response_code(400);
}

function generarCSV($tableName, $fechaInicio, $fechaFin){

    try {

        if( !$conn = getConnection() ) throw new Exception('Error en la conexion');

        // Sanitizar y validar los datos
        $tableName = pg_escape_string($conn, $tableName);
        $fechaInicio = pg_escape_string($conn, $fechaInicio);
        $fechaFin = pg_escape_string($conn, $fechaFin);

        $sQuery = "SELECT * FROM $tableName WHERE fecha_insercion BETWEEN '$fechaInicio' AND '$fechaFin'";

        // if( !$result = @pg_query($conn, $sQuery) ) throw new Exception("Error en la consulta: " . pg_last_error($conn));
        if( !$result = @pg_query($conn, $sQuery) ) throw new Exception("Error en la consulta: tabla '{$tableName}'");

        $filename = "{$tableName}_{$fechaInicio}_{$fechaFin}.xlsx";
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
                
        $count = 0;
        while ($row = pg_fetch_assoc($result)) {
            unset($row['fecha_insercion'], $row['folio_uuid']);

            if( $count === 0) fputcsv( $output, array_keys( $row ) );
            $count++;

            fputcsv($output, $row);
        }
        
        fclose($output);
        pg_close($conn);
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>