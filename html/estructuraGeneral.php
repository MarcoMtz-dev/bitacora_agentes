<?php

$blocks = [];

$use_form = @$_GET['use_form'];
$use_head = @$_GET['use_head'];
$is_consulta = isset( $_GET['is_consult'] );

$headFile = "./heads/{$use_head}.html";
$formFile = "./forms/{$use_form}.html";
$consult_part = "./consultas_part/consultas_{$use_form}.html";

if( file_exists( $headFile  ) ){
    $blocks['head'] = file_get_contents( $headFile );
}

if( file_exists( $formFile ) ){
    $blocks['form'] = file_get_contents( $formFile );
}else{
    exit;
}

if( $is_consulta && file_exists( $consult_part ) ){
    $blocks['form'] .= file_get_contents( $consult_part );
    $blocks['footer'] = file_get_contents( './searchModal.html' );
}

if( $is_consulta ){
    @$blocks['head'] .= '<script src="../js/eventosConsulta.js"></script>';
    @$blocks['head'] .= '<script src="../js/eventosSearch.js"></script>';
}else{
    @$blocks['head'] .= '<script src="../js/eventosCaptura.js"></script>';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <link rel="stylesheet" href="../css/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/estilosGenerales.css">

    <script src="http://10.30.248.4:50/utiles/componentes.js"></script>
    <script src="../js/sweetalert2.min.js"></script>
    <script src="../js/eventosGenerales.js"></script>

    <?php echo @$blocks['head']; ?>

</head>
<body>
    <main>

        <form id="formulario">
            
            <?php echo @$blocks['form']; ?>

            <div class="btn-group">
                <input class="btn btn-danger" type="reset" value="Restablecer">
                <input class="btn btn-success" type="submit" value="Enviar">
            </div>

        </form>

    </main>

    <?php echo @$blocks['footer']; ?>
</body>
</html>