<?php
    session_start();
    if ( !isset($_SESSION["userId"]) ) header('Location: ./');

    function validUser( Array $validSessions ){
        return in_array( strtoupper( $_SESSION['rolType'] ), $validSessions );
    }
?>

<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitacora Bancoppel</title>

    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/switchDarkmode.css">

    <script src="./js/eventos.js"></script>

</head>

<body>

    <aside>

        <div class="sidebar-header">

            <div class="sidebar-opener">
                <label for="chboxSideBarOpener">
                    <svg class="svgOpener svgOpener-closer" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M18.36 19.78L12 13.41l-6.36 6.37l-1.42-1.42L10.59 12L4.22 5.64l1.42-1.42L12 10.59l6.36-6.36l1.41 1.41L13.41 12l6.36 6.36z" /></svg>
                    <svg class="svgOpener svgOpener-opener" width="1.46em" height="1em" viewBox="0 0 16 11"><path fill="currentColor" d="M12.5 3h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5m0 3h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5m0 3h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" /></svg>
                </label>
                <input class="inputOpener" type="checkbox" id="chboxSideBarOpener" checked>
            </div>

            <div class="sidebar-logo">
                <img src="./img/CoppelKey.png" alt="Icono Bancoppel">
                <span class="displayOnOpen">BanCoppel</span>
            </div>

            <div class="displayOnOpen">
                <span><?php echo "{$_SESSION['username']} - {$_SESSION['rolType']}";  ?></span>
            </div>

        </div>

        <div class="sidebar-body">

            <?php if( validUser( ['CONSULTOR','AGENTE']) ){ ?>
            <div class="dropdown-container">
                <label class="sidebar-item" data-otherOpener>
                    <input type="radio" name="captura_1">
                    <svg width="1em" height="1em" viewBox="0 0 1024 1024">
                        <path fill="currentColor"
                            d="M904 512h-56c-4.4 0-8 3.6-8 8v320H184V184h320c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V520c0-4.4-3.6-8-8-8" />
                        <path fill="currentColor"
                            d="M355.9 534.9L354 653.8c-.1 8.9 7.1 16.2 16 16.2h.4l118-2.9c2-.1 4-.9 5.4-2.3l415.9-415c3.1-3.1 3.1-8.2 0-11.3L785.4 114.3c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-415.8 415a8.3 8.3 0 0 0-2.3 5.6m63.5 23.6L779.7 199l45.2 45.1l-360.5 359.7l-45.7 1.1z" />
                    </svg>
                    <span class="displayOnOpen">Capturar</span>
                </label>

                <div class="dropdown-items">

                    <div class="dropdown-container">
                        <label class="sidebar-item">
                            <input type="radio" name="captura_1_1">
                            <svg width="1em" height="1em" viewBox="0 0 16 16">
                                <g fill="currentColor">
                                    <path
                                        d="M5 8a2 2 0 1 0 0-4a2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                                    <path
                                        d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
                                </g>
                            </svg>
                            <span class="displayOnOpen">Situaciones Ajenas y Sucursales</span>
                        </label>
                        <div class="dropdown-items">

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_situaciones_ajenas">
                                <svg width="0.63em" height="1em" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M112 48a48 48 0 1 1 96 0a48 48 0 1 1-96 0m40 304v128c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9l-28.6 47.6c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352z" />
                                </svg>
                                <span>Situaciones Ajenas</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_sucursales">
                                <svg width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M14 8h1a1 1 0 0 0 0-2h-1a1 1 0 0 0 0 2m0 4h1a1 1 0 0 0 0-2h-1a1 1 0 0 0 0 2M9 8h1a1 1 0 0 0 0-2H9a1 1 0 0 0 0 2m0 4h1a1 1 0 0 0 0-2H9a1 1 0 0 0 0 2m12 8h-1V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v17H3a1 1 0 0 0 0 2h18a1 1 0 0 0 0-2m-8 0h-2v-4h2Zm5 0h-3v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5H6V4h12Z" />
                                </svg>
                                <span>Sucursales</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_quejas_notificaciones_erroneas">
                                <svg width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M4 8a8 8 0 1 1 16 0v4.697l2 3V20H2v-4.303l2-3zm7-2v6h2V6zm2.004 7.5H11v2.004h2.004zM8.645 21a3.502 3.502 0 0 0 6.71 0z" />
                                </svg>
                                <span>Quejas Notificaciones Erróneas</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_quejas_une_fb">
                                <svg width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"
                                        strokeWidth="1.5"
                                        d="M16.996 9.013h.008m0-2.004V4.505M22 6.792c0 2.646-2.24 4.792-5.004 4.792q-.488 0-.968-.09c-.23-.043-.344-.064-.425-.052c-.08.012-.194.072-.42.194a3.25 3.25 0 0 1-2.114.329c.274-.338.46-.743.543-1.177c.05-.265-.074-.523-.26-.712a4.67 4.67 0 0 1-1.36-3.284c0-2.646 2.24-4.792 5.004-4.792S22 4.146 22 6.792M7.502 22H4.718c-.323 0-.648-.046-.945-.173c-.966-.415-1.457-.964-1.685-1.307a.54.54 0 0 1 .03-.631c1.12-1.488 3.716-2.386 5.384-2.386M7.507 22h2.783c.324 0 .648-.046.945-.173c.967-.415 1.457-.964 1.686-1.307a.54.54 0 0 0-.03-.631c-1.12-1.488-3.716-2.386-5.384-2.386m2.778-5.214a2.776 2.776 0 0 1-2.778 2.772a2.776 2.776 0 0 1-2.78-2.772a2.776 2.776 0 0 1 2.78-2.773a2.776 2.776 0 0 1 2.778 2.773"
                                        color="currentColor" />
                                </svg>
                                <span>Quejas UNE-FB</span>
                            </label>

                        </div>
                    </div>

                    <div class="dropdown-container">
                        <label class="sidebar-item">
                            <input type="radio" name="captura_1_1">
                            <svg width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" strokeWidth="1.5">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10" />
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M13 2.05S16 6 16 12m-5 9.95S8 18 8 12s3-9.95 3-9.95M2.63 15.5H12m-9.37-7h18.74" />
                                    <path
                                        d="M21.879 17.917c.494.304.463 1.043-.045 1.101l-2.567.291l-1.151 2.312c-.228.459-.933.234-1.05-.334l-1.255-6.116c-.099-.48.333-.782.75-.525z"
                                        clipRule="evenodd" />
                                </g>
                            </svg>
                            <span class="displayOnOpen">Liga Incidencias App BanCoppel y Banca por Internet</span>
                        </label>
                        <div class="dropdown-items">

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_appbcpl_incidencias">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                    <g fill="currentColor">
                                        <path fillRule="evenodd"
                                            d="M21.407 15.092a5.402 5.402 0 0 1 3.477 8.33L38.718 34.16a2.25 2.25 0 1 1-1.182 1.614l-14.07-10.922a5.4 5.4 0 1 1-4.058-9.76L19.406 6h2zm.799 5.308a1.8 1.8 0 1 1-3.6 0a1.8 1.8 0 0 1 3.6 0"
                                            clipRule="evenodd" />
                                        <path
                                            d="M27.63 20.384a7.2 7.2 0 0 0-4.223-6.558v-7.72c4.289.377 6.517 1.728 8.512 3.577q.151.141.296.273v.001c.85.78 1.526 1.401 1.875 2.331l4.234 11.272a2 2 0 0 1-1.873 2.701H34.82V28.6l-7.575-5.882a7.2 7.2 0 0 0 .386-2.333m-10.224-6.539V6.241c-8.99 1.353-11.403 8.06-11.403 11.734c0 5.767 3.683 10.24 5.41 12.033V42h17.112v-6.512h4.293c.302 0 .59-.068.846-.188L23.08 27.08a7.2 7.2 0 0 1-5.673-13.234" />
                                    </g>
                                </svg>
                                <span class="displayOnOpen">AppBcpl Incidencias CAT</span>
                            </label>

                        </div>
                    </div>

                    <div class="dropdown-container">
                        <label class="sidebar-item">
                            <input type="radio" name="captura_1_1">
                            <svg width="1em" height="1em" viewBox="0 0 256 256">
                                <path fill="currentColor"
                                    d="M200 24H56a16 16 0 0 0-16 16v176a16 16 0 0 0 16 16h144a16 16 0 0 0 16-16V40a16 16 0 0 0-16-16m-48 120h48v24h-88v-24Zm8-16v-24h40v24Zm40-88v48h-48a8 8 0 0 0-8 8v32h-40a8 8 0 0 0-8 8v32H56V40Zm0 176H56v-32h144z" />
                            </svg>
                            <span class="displayOnOpen">Concentrado Escalamientos</span>
                        </label>
                        <div class="dropdown-items">

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_chequeras">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m21.4 14.35l-6.35 6.35q-.15.15-.337.225t-.388.075H13.5q-.2 0-.35-.15T13 20.5v-.825q0-.2.075-.387t.225-.338l6.35-6.35zM2 17V7q0-.825.588-1.412T4 5h16q.825 0 1.413.588T22 7q0 .275-.3.638T21 8h-.175q-.4 0-.763.15t-.637.425l-3.85 3.85q-.275.275-.637.425t-.763.15H7q-.425 0-.712.288T6 14t.288.713T7 15h4.8q.35 0 .475.3t-.125.55l-2.575 2.575q-.275.275-.637.425t-.763.15H4q-.825 0-1.412-.587T2 17m5-6h4q.425 0 .713-.288T12 10t-.288-.712T11 9H7q-.425 0-.712.288T6 10t.288.713T7 11m15 2.75L20.25 12l.9-.9q.125-.125.275-.125t.275.125l1.2 1.2q.125.125.125.275t-.125.275z" />
                                </svg>
                                <span class="displayOnOpen">CHEQUERAS</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_tdc_oro_no_sucursal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 19c0-.34.04-.67.09-1H3v-6h16v1c.7 0 1.37.13 2 .35V6c0-1.11-.89-2-2-2H3c-1.11 0-2 .89-2 2v12a2 2 0 0 0 2 2h10.09c-.05-.33-.09-.66-.09-1M3 6h16v2H3zm19.54 10.88L20.41 19l2.13 2.12l-1.42 1.42L19 20.41l-2.12 2.13l-1.41-1.42L17.59 19l-2.12-2.12l1.41-1.41L19 17.59l2.12-2.13z" />
                                </svg>
                                <span class="displayOnOpen">TDC ORO QUE NO LLEGAN A SUCURSAL</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_comisiones_corresponsales">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 28 28">
                                    <path fill="currentColor"
                                        d="M14 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m.89-6.705a1.5 1.5 0 0 0-1.78 0L3.61 9.3c-1.164.859-.557 2.707.89 2.707H5v7.242a3.25 3.25 0 0 0-2 3.001v1.5c0 .414.336.75.75.75h20.5a.75.75 0 0 0 .75-.75v-1.5a3.25 3.25 0 0 0-2-3v-7.243h.499c1.448 0 2.055-1.848.89-2.707zM6.5 19v-6.993H9V19zm15-6.993V19H19v-6.993zm-4 0V19h-2.75v-6.993zm-4.25 0V19H10.5v-6.993zm-8.75-1.5L14 3.502l9.499 7.005zm0 11.743c0-.966.784-1.75 1.75-1.75h15.5c.966 0 1.75.784 1.75 1.75V23h-19z" />
                                </svg>
                                <span class="displayOnOpen">COMISIONES Y CORRESPONSALES</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_a_errores_generados">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M5.6 3H3.5A1.5 1.5 0 0 0 2 4.5v5A1.5 1.5 0 0 0 3.5 11H5v2.898L8.312 11H12.5a1.5 1.5 0 0 0 1.477-1.239A5.5 5.5 0 0 0 15 8.664V9.5a2.5 2.5 0 0 1-2.5 2.5H8.688l-3.063 2.68A.98.98 0 0 1 4 13.942V12h-.5A2.5 2.5 0 0 1 1 9.5v-5A2.5 2.5 0 0 1 3.5 2h2.757A5.5 5.5 0 0 0 5.6 3m4.9 7a4.5 4.5 0 1 0 0-9a4.5 4.5 0 0 0 0 9M10 3.5a.5.5 0 0 1 1 0v2a.5.5 0 0 1-1 0zm1.125 4a.625.625 0 1 1-1.25 0a.625.625 0 0 1 1.25 0" />
                                </svg>
                                <span class="displayOnOpen">A_Errorres Generados</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_codigos_vcas">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                    <g fill="currentColor">
                                        <path d="M12.675 15.138a.675.675 0 1 1-1.35 0a.675.675 0 0 1 1.35 0" />
                                        <path fillRule="evenodd"
                                            d="M12 14.963a.175.175 0 1 0 0 .35a.175.175 0 0 0 0-.35m-1.175.175a1.175 1.175 0 1 1 2.35 0a1.175 1.175 0 0 1-2.35 0"
                                            clipRule="evenodd" />
                                        <path fillRule="evenodd"
                                            d="M6 3.5A2.5 2.5 0 0 1 8.5 1h7A2.5 2.5 0 0 1 18 3.5v13a2.5 2.5 0 0 1-2.5 2.5H8a2 2 0 0 1-2-2v-1a.5.5 0 0 1 1 0v1a1 1 0 0 0 1 1h7.5a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 15.5 2h-7A1.5 1.5 0 0 0 7 3.5v3a.5.5 0 0 1-1 0z"
                                            clipRule="evenodd" />
                                        <path fillRule="evenodd"
                                            d="M7.64 8.974a2.693 2.693 0 1 0-3.152 4.367A2.693 2.693 0 0 0 7.64 8.974m-4.57.022a3.693 3.693 0 1 1 1.258 5.421L1.994 17.65a.5.5 0 1 1-.81-.586l2.333-3.232a3.694 3.694 0 0 1-.447-4.836"
                                            clipRule="evenodd" />
                                    </g>
                                </svg>
                                <span class="displayOnOpen">CÓDIGO VCAS</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_a_portabilidad_nomina">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                    <g fill="currentColor">
                                        <path
                                            d="M16 152h32v56H16a8 8 0 0 1-8-8v-40a8 8 0 0 1 8-8m188-96a28 28 0 0 0-12 2.71a28 28 0 1 0-16 26.58A28 28 0 1 0 204 56"
                                            opacity=".2" />
                                        <path
                                            d="M230.33 141.06a24.43 24.43 0 0 0-21.24-4.23l-41.84 9.62A28 28 0 0 0 140 112H89.94a31.82 31.82 0 0 0-22.63 9.37L44.69 144H16a16 16 0 0 0-16 16v40a16 16 0 0 0 16 16h104a8 8 0 0 0 1.94-.24l64-16a7 7 0 0 0 1.19-.4L226 182.82l.44-.2a24.6 24.6 0 0 0 3.93-41.56ZM16 160h24v40H16Zm203.43 8.21l-38 16.18L119 200H56v-44.69l22.63-22.62A15.86 15.86 0 0 1 89.94 128H140a12 12 0 0 1 0 24h-28a8 8 0 0 0 0 16h32a8.3 8.3 0 0 0 1.79-.2l67-15.41l.31-.08a8.6 8.6 0 0 1 6.3 15.9ZM164 96a36 36 0 0 0 5.9-.48a36 36 0 1 0 28.22-47A36 36 0 1 0 164 96m60-12a20 20 0 1 1-20-20a20 20 0 0 1 20 20m-60-44a20 20 0 0 1 19.25 14.61a36 36 0 0 0-15 24.93A20.4 20.4 0 0 1 164 80a20 20 0 0 1 0-40" />
                                    </g>
                                </svg>
                                <span class="displayOnOpen">A_Portabilidad de Nómina</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_i_anticipo_nomina">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 26 26">
                                    <path fill="currentColor"
                                        d="M16.688 0c-.2.008-.393.044-.594.094L2.5 3.406C.892 3.8-.114 5.422.281 7.031l1.906 7.782A2.99 2.99 0 0 0 4 16.875V15c0-2.757 2.243-5 5-5h12.594l-1.875-7.719A3.004 3.004 0 0 0 16.687 0zm1.218 4.313l.813 3.406l-3.375.812l-.844-3.375zM9 12c-1.656 0-3 1.344-3 3v8c0 1.656 1.344 3 3 3h14c1.656 0 3-1.344 3-3v-8c0-1.656-1.344-3-3-3zm0 1.594h14c.771 0 1.406.635 1.406 1.406v1H7.594v-1c0-.771.635-1.406 1.406-1.406M7.594 19h16.812v4c0 .771-.635 1.406-1.406 1.406H9A1.414 1.414 0 0 1 7.594 23z" />
                                </svg>
                                <span class="displayOnOpen">I_Anticipo de nomina</span>
                            </label>

                        </div>
                    </div>

                </div>

            </div>
            <?php } ?>

            <?php if( validUser( ['CONSULTOR','AGENTE']) ){ ?>
            <div class="dropdown-container">
                <label class="sidebar-item" data-otherOpener>
                    <input type="radio" name="captura_1">
                    <svg width="1.15em" height="1em" viewBox="0 0 1025 896">
                        <path fill="currentColor"
                            d="M1024.526 768q0 53-37.5 90.5t-90.5 37.5h-768q-53 0-90.5-37.5T.526 768V256q0-26 18.5-45t45.5-19h480q0-12 11.5-33t22.5-36l12-16q7-18 28-30.5t44-12.5h240q24 0 45 12.5t28 30.5q49 58 49 85zm-978-725q7-18 28-30.5t44-12.5h240q24 0 45 12.5t29 30.5l48 85h-480z" />
                    </svg>
                    <span class="displayOnOpen">Consultar</span>
                </label>

                <div class="dropdown-items">

                    <div class="dropdown-container">
                        <label class="sidebar-item">
                            <input type="radio" name="captura_1_1">
                            <svg width="1em" height="1em" viewBox="0 0 24 24">
                                <g className="warning-outline">
                                    <g fill="currentColor" className="Vector">
                                        <path fillRule="evenodd"
                                            d="M12 13.8a1 1 0 0 1-1-1v-5a1 1 0 0 1 2 0v5a1 1 0 0 1-1 1"
                                            clipRule="evenodd" />
                                        <path d="M10.947 15.958a1.053 1.053 0 1 1 2.106 0a1.053 1.053 0 0 1-2.106 0" />
                                        <path fillRule="evenodd"
                                            d="m15.607 4.642l5.876 10.72c1.512 2.759-.473 6.138-3.607 6.138H6.124c-3.134 0-5.12-3.38-3.607-6.139l5.876-10.72c1.566-2.855 5.648-2.855 7.214 0Zm-1.804 1c-.782-1.429-2.824-1.429-3.606 0L4.32 16.36c-.757 1.38.236 3.069 1.803 3.069h11.752c1.567 0 2.56-1.69 1.803-3.07z"
                                            clipRule="evenodd" />
                                    </g>
                                </g>
                            </svg>
                            <span class="displayOnOpen">Situaciones Ajenas y Sucursales</span>
                        </label>
                        <div class="dropdown-items">

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_situaciones_ajenas&is_consult">
                                <svg width="0.63em" height="1em" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M112 48a48 48 0 1 1 96 0a48 48 0 1 1-96 0m40 304v128c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9l-28.6 47.6c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352z" />
                                </svg>
                                <span>Situaciones Ajenas</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_sucursales&is_consult">
                                <svg width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M14 8h1a1 1 0 0 0 0-2h-1a1 1 0 0 0 0 2m0 4h1a1 1 0 0 0 0-2h-1a1 1 0 0 0 0 2M9 8h1a1 1 0 0 0 0-2H9a1 1 0 0 0 0 2m0 4h1a1 1 0 0 0 0-2H9a1 1 0 0 0 0 2m12 8h-1V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v17H3a1 1 0 0 0 0 2h18a1 1 0 0 0 0-2m-8 0h-2v-4h2Zm5 0h-3v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5H6V4h12Z" />
                                </svg>
                                <span>Sucursales</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_quejas_notificaciones_erroneas&is_consult">
                                <svg width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M4 8a8 8 0 1 1 16 0v4.697l2 3V20H2v-4.303l2-3zm7-2v6h2V6zm2.004 7.5H11v2.004h2.004zM8.645 21a3.502 3.502 0 0 0 6.71 0z" />
                                </svg>
                                <span>Quejas Notificaciones Erróneas</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_quejas_une_fb&is_consult">
                                <svg width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"
                                        strokeWidth="1.5"
                                        d="M16.996 9.013h.008m0-2.004V4.505M22 6.792c0 2.646-2.24 4.792-5.004 4.792q-.488 0-.968-.09c-.23-.043-.344-.064-.425-.052c-.08.012-.194.072-.42.194a3.25 3.25 0 0 1-2.114.329c.274-.338.46-.743.543-1.177c.05-.265-.074-.523-.26-.712a4.67 4.67 0 0 1-1.36-3.284c0-2.646 2.24-4.792 5.004-4.792S22 4.146 22 6.792M7.502 22H4.718c-.323 0-.648-.046-.945-.173c-.966-.415-1.457-.964-1.685-1.307a.54.54 0 0 1 .03-.631c1.12-1.488 3.716-2.386 5.384-2.386M7.507 22h2.783c.324 0 .648-.046.945-.173c.967-.415 1.457-.964 1.686-1.307a.54.54 0 0 0-.03-.631c-1.12-1.488-3.716-2.386-5.384-2.386m2.778-5.214a2.776 2.776 0 0 1-2.778 2.772a2.776 2.776 0 0 1-2.78-2.772a2.776 2.776 0 0 1 2.78-2.773a2.776 2.776 0 0 1 2.778 2.773"
                                        color="currentColor" />
                                </svg>
                                <span>Quejas UNE-FB</span>
                            </label>

                        </div>
                    </div>

                    <div class="dropdown-container">
                        <label class="sidebar-item">
                            <input type="radio" name="captura_1_1">
                            <svg width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" strokeWidth="1.5">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10" />
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M13 2.05S16 6 16 12m-5 9.95S8 18 8 12s3-9.95 3-9.95M2.63 15.5H12m-9.37-7h18.74" />
                                    <path
                                        d="M21.879 17.917c.494.304.463 1.043-.045 1.101l-2.567.291l-1.151 2.312c-.228.459-.933.234-1.05-.334l-1.255-6.116c-.099-.48.333-.782.75-.525z"
                                        clipRule="evenodd" />
                                </g>
                            </svg>
                            <span class="displayOnOpen">Liga Incidencias App BanCoppel y Banca por Internet</span>
                        </label>
                        <div class="dropdown-items">

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_appbcpl_incidencias&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                    <g fill="currentColor">
                                        <path fillRule="evenodd"
                                            d="M21.407 15.092a5.402 5.402 0 0 1 3.477 8.33L38.718 34.16a2.25 2.25 0 1 1-1.182 1.614l-14.07-10.922a5.4 5.4 0 1 1-4.058-9.76L19.406 6h2zm.799 5.308a1.8 1.8 0 1 1-3.6 0a1.8 1.8 0 0 1 3.6 0"
                                            clipRule="evenodd" />
                                        <path
                                            d="M27.63 20.384a7.2 7.2 0 0 0-4.223-6.558v-7.72c4.289.377 6.517 1.728 8.512 3.577q.151.141.296.273v.001c.85.78 1.526 1.401 1.875 2.331l4.234 11.272a2 2 0 0 1-1.873 2.701H34.82V28.6l-7.575-5.882a7.2 7.2 0 0 0 .386-2.333m-10.224-6.539V6.241c-8.99 1.353-11.403 8.06-11.403 11.734c0 5.767 3.683 10.24 5.41 12.033V42h17.112v-6.512h4.293c.302 0 .59-.068.846-.188L23.08 27.08a7.2 7.2 0 0 1-5.673-13.234" />
                                    </g>
                                </svg>
                                <span class="displayOnOpen">AppBcpl Incidencias CAT</span>
                            </label>

                        </div>
                    </div>

                    <div class="dropdown-container">
                        <label class="sidebar-item">
                            <input type="radio" name="captura_1_1">
                            <svg width="1em" height="1em" viewBox="0 0 256 256">
                                <path fill="currentColor"
                                    d="M200 24H56a16 16 0 0 0-16 16v176a16 16 0 0 0 16 16h144a16 16 0 0 0 16-16V40a16 16 0 0 0-16-16m-48 120h48v24h-88v-24Zm8-16v-24h40v24Zm40-88v48h-48a8 8 0 0 0-8 8v32h-40a8 8 0 0 0-8 8v32H56V40Zm0 176H56v-32h144z" />
                            </svg>
                            <span class="displayOnOpen">Concentrado Escalamientos</span>
                        </label>
                        <div class="dropdown-items">

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_chequeras&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m21.4 14.35l-6.35 6.35q-.15.15-.337.225t-.388.075H13.5q-.2 0-.35-.15T13 20.5v-.825q0-.2.075-.387t.225-.338l6.35-6.35zM2 17V7q0-.825.588-1.412T4 5h16q.825 0 1.413.588T22 7q0 .275-.3.638T21 8h-.175q-.4 0-.763.15t-.637.425l-3.85 3.85q-.275.275-.637.425t-.763.15H7q-.425 0-.712.288T6 14t.288.713T7 15h4.8q.35 0 .475.3t-.125.55l-2.575 2.575q-.275.275-.637.425t-.763.15H4q-.825 0-1.412-.587T2 17m5-6h4q.425 0 .713-.288T12 10t-.288-.712T11 9H7q-.425 0-.712.288T6 10t.288.713T7 11m15 2.75L20.25 12l.9-.9q.125-.125.275-.125t.275.125l1.2 1.2q.125.125.125.275t-.125.275z" />
                                </svg>
                                <span class="displayOnOpen">CHEQUERAS</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_tdc_oro_no_sucursal&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 19c0-.34.04-.67.09-1H3v-6h16v1c.7 0 1.37.13 2 .35V6c0-1.11-.89-2-2-2H3c-1.11 0-2 .89-2 2v12a2 2 0 0 0 2 2h10.09c-.05-.33-.09-.66-.09-1M3 6h16v2H3zm19.54 10.88L20.41 19l2.13 2.12l-1.42 1.42L19 20.41l-2.12 2.13l-1.41-1.42L17.59 19l-2.12-2.12l1.41-1.41L19 17.59l2.12-2.13z" />
                                </svg>
                                <span class="displayOnOpen">TDC ORO QUE NO LLEGAN A SUCURSAL</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_comisiones_corresponsales&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 28 28">
                                    <path fill="currentColor"
                                        d="M14 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m.89-6.705a1.5 1.5 0 0 0-1.78 0L3.61 9.3c-1.164.859-.557 2.707.89 2.707H5v7.242a3.25 3.25 0 0 0-2 3.001v1.5c0 .414.336.75.75.75h20.5a.75.75 0 0 0 .75-.75v-1.5a3.25 3.25 0 0 0-2-3v-7.243h.499c1.448 0 2.055-1.848.89-2.707zM6.5 19v-6.993H9V19zm15-6.993V19H19v-6.993zm-4 0V19h-2.75v-6.993zm-4.25 0V19H10.5v-6.993zm-8.75-1.5L14 3.502l9.499 7.005zm0 11.743c0-.966.784-1.75 1.75-1.75h15.5c.966 0 1.75.784 1.75 1.75V23h-19z" />
                                </svg>
                                <span class="displayOnOpen">COMISIONES Y CORRESPONSALES</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_a_errores_generados&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M5.6 3H3.5A1.5 1.5 0 0 0 2 4.5v5A1.5 1.5 0 0 0 3.5 11H5v2.898L8.312 11H12.5a1.5 1.5 0 0 0 1.477-1.239A5.5 5.5 0 0 0 15 8.664V9.5a2.5 2.5 0 0 1-2.5 2.5H8.688l-3.063 2.68A.98.98 0 0 1 4 13.942V12h-.5A2.5 2.5 0 0 1 1 9.5v-5A2.5 2.5 0 0 1 3.5 2h2.757A5.5 5.5 0 0 0 5.6 3m4.9 7a4.5 4.5 0 1 0 0-9a4.5 4.5 0 0 0 0 9M10 3.5a.5.5 0 0 1 1 0v2a.5.5 0 0 1-1 0zm1.125 4a.625.625 0 1 1-1.25 0a.625.625 0 0 1 1.25 0" />
                                </svg>
                                <span class="displayOnOpen">A_Errorres Generados</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_codigos_vcas&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                    <g fill="currentColor">
                                        <path d="M12.675 15.138a.675.675 0 1 1-1.35 0a.675.675 0 0 1 1.35 0" />
                                        <path fillRule="evenodd"
                                            d="M12 14.963a.175.175 0 1 0 0 .35a.175.175 0 0 0 0-.35m-1.175.175a1.175 1.175 0 1 1 2.35 0a1.175 1.175 0 0 1-2.35 0"
                                            clipRule="evenodd" />
                                        <path fillRule="evenodd"
                                            d="M6 3.5A2.5 2.5 0 0 1 8.5 1h7A2.5 2.5 0 0 1 18 3.5v13a2.5 2.5 0 0 1-2.5 2.5H8a2 2 0 0 1-2-2v-1a.5.5 0 0 1 1 0v1a1 1 0 0 0 1 1h7.5a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 15.5 2h-7A1.5 1.5 0 0 0 7 3.5v3a.5.5 0 0 1-1 0z"
                                            clipRule="evenodd" />
                                        <path fillRule="evenodd"
                                            d="M7.64 8.974a2.693 2.693 0 1 0-3.152 4.367A2.693 2.693 0 0 0 7.64 8.974m-4.57.022a3.693 3.693 0 1 1 1.258 5.421L1.994 17.65a.5.5 0 1 1-.81-.586l2.333-3.232a3.694 3.694 0 0 1-.447-4.836"
                                            clipRule="evenodd" />
                                    </g>
                                </svg>
                                <span class="displayOnOpen">CÓDIGO VCAS</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_a_portabilidad_nomina&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                    <g fill="currentColor">
                                        <path
                                            d="M16 152h32v56H16a8 8 0 0 1-8-8v-40a8 8 0 0 1 8-8m188-96a28 28 0 0 0-12 2.71a28 28 0 1 0-16 26.58A28 28 0 1 0 204 56"
                                            opacity=".2" />
                                        <path
                                            d="M230.33 141.06a24.43 24.43 0 0 0-21.24-4.23l-41.84 9.62A28 28 0 0 0 140 112H89.94a31.82 31.82 0 0 0-22.63 9.37L44.69 144H16a16 16 0 0 0-16 16v40a16 16 0 0 0 16 16h104a8 8 0 0 0 1.94-.24l64-16a7 7 0 0 0 1.19-.4L226 182.82l.44-.2a24.6 24.6 0 0 0 3.93-41.56ZM16 160h24v40H16Zm203.43 8.21l-38 16.18L119 200H56v-44.69l22.63-22.62A15.86 15.86 0 0 1 89.94 128H140a12 12 0 0 1 0 24h-28a8 8 0 0 0 0 16h32a8.3 8.3 0 0 0 1.79-.2l67-15.41l.31-.08a8.6 8.6 0 0 1 6.3 15.9ZM164 96a36 36 0 0 0 5.9-.48a36 36 0 1 0 28.22-47A36 36 0 1 0 164 96m60-12a20 20 0 1 1-20-20a20 20 0 0 1 20 20m-60-44a20 20 0 0 1 19.25 14.61a36 36 0 0 0-15 24.93A20.4 20.4 0 0 1 164 80a20 20 0 0 1 0-40" />
                                    </g>
                                </svg>
                                <span class="displayOnOpen">A_Portabilidad de Nómina</span>
                            </label>

                            <label class="sidebar-item">
                                <input type="radio" name="captura_1_1_1"
                                    data-src="./html/estructuraGeneral.php?use_form=form_i_anticipo_nomina&is_consult">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 26 26">
                                    <path fill="currentColor"
                                        d="M16.688 0c-.2.008-.393.044-.594.094L2.5 3.406C.892 3.8-.114 5.422.281 7.031l1.906 7.782A2.99 2.99 0 0 0 4 16.875V15c0-2.757 2.243-5 5-5h12.594l-1.875-7.719A3.004 3.004 0 0 0 16.687 0zm1.218 4.313l.813 3.406l-3.375.812l-.844-3.375zM9 12c-1.656 0-3 1.344-3 3v8c0 1.656 1.344 3 3 3h14c1.656 0 3-1.344 3-3v-8c0-1.656-1.344-3-3-3zm0 1.594h14c.771 0 1.406.635 1.406 1.406v1H7.594v-1c0-.771.635-1.406 1.406-1.406M7.594 19h16.812v4c0 .771-.635 1.406-1.406 1.406H9A1.414 1.414 0 0 1 7.594 23z" />
                                </svg>
                                <span class="displayOnOpen">I_Anticipo de nomina</span>
                            </label>

                        </div>
                    </div>

                    <?php if( validUser( ['CONSULTOR'] ) ){ ?>

                    <div class="dropdown-container">
                        <label class="sidebar-item">
                            <input type="radio" name="captura_1_1" data-src="./html/descarga_archivos_csv.html">
                            <svg width="1em" height="1em" viewBox="0 0 16 16">
                                <path fill="currentColor"
                                    d="m8 9l4-4H9V1H7v4H4zm3.636-1.636l-1.121 1.121L14.579 10L8 12.453L1.421 10l4.064-1.515l-1.121-1.121L0 9v4l8 3l8-3V9z" />
                            </svg>
                            <span class="displayOnOpen">Descarga de datos</span>
                        </label>

                    </div>

                    <?php } ?>

                </div>

            </div>
            <?php } ?>

            <div class="dropdown-container">
                
                <label class="sidebar-item" data-otherOpener>
                    <input type="radio" name="captura_1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256"><path fill="currentColor" d="M243.6 148.8a6 6 0 0 1-8.4-1.2A53.58 53.58 0 0 0 192 126a6 6 0 0 1 0-12a26 26 0 1 0-25.18-32.5a6 6 0 0 1-11.62-3a38 38 0 1 1 59.91 39.63a65.7 65.7 0 0 1 29.69 22.27a6 6 0 0 1-1.2 8.4M189.19 213a6 6 0 0 1-2.19 8.2a5.9 5.9 0 0 1-3 .81a6 6 0 0 1-5.2-3a59 59 0 0 0-101.62 0a6 6 0 1 1-10.38-6a70.1 70.1 0 0 1 36.2-30.46a46 46 0 1 1 50.1 0A70.1 70.1 0 0 1 189.19 213M128 178a34 34 0 1 0-34-34a34 34 0 0 0 34 34m-58-58a6 6 0 0 0-6-6a26 26 0 1 1 25.18-32.51a6 6 0 1 0 11.62-3a38 38 0 1 0-59.91 39.63A65.7 65.7 0 0 0 11.2 140.4a6 6 0 1 0 9.6 7.2A53.58 53.58 0 0 1 64 126a6 6 0 0 0 6-6"/></svg>
                    <span class="displayOnOpen">Gestión de usuario</span>
                </label>

                <div class="dropdown-items">

                <?php if( validUser(['ADMIN']) ){ ?>

                    <label class="sidebar-item">
                        <input type="radio" name="captura_1_1" data-src="./html/userSettings/deleteUsers.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M14 4c-3.854 0-7 3.146-7 7c0 2.41 1.23 4.552 3.094 5.813C6.527 18.343 4 21.88 4 26h2c0-4.43 3.57-8 8-8c1.376 0 2.654.358 3.78.97A8 8 0 0 0 16 24c0 4.406 3.594 8 8 8s8-3.594 8-8s-3.594-8-8-8a7.98 7.98 0 0 0-4.688 1.53c-.442-.277-.92-.51-1.406-.718A7.02 7.02 0 0 0 21 11c0-3.854-3.146-7-7-7m0 2c2.773 0 5 2.227 5 5s-2.227 5-5 5s-5-2.227-5-5s2.227-5 5-5m10 12c3.326 0 6 2.674 6 6s-2.674 6-6 6s-6-2.674-6-6s2.674-6 6-6m-2.28 2.28l-1.44 1.44L22.563 24l-2.28 2.28l1.437 1.44L24 25.437l2.28 2.28l1.44-1.437L25.437 24l2.28-2.28l-1.437-1.44L24 22.563l-2.28-2.28z"/></svg>
                        <span class="displayOnOpen">Baja de usuarios</span>
                    </label>
                    
                    <label class="sidebar-item">
                        <input type="radio" name="captura_1_1" data-src="./html/userSettings/updateRol.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M16 5c-3.9 0-7 3.1-7 7a6.96 6.96 0 0 0 3.07 5.813C8.51 19.346 6 22.892 6 27h2c0-4.4 3.6-8 8-8c3.9 0 7-3.1 7-7s-3.1-7-7-7m0 2c2.8 0 5 2.2 5 5s-2.2 5-5 5s-5-2.2-5-5s2.2-5 5-5m8.1 11v2.1c-.6.1-1.2.4-1.7.7l-1.5-1.5l-1.4 1.4l1.5 1.5c-.4.5-.6 1.1-.7 1.8H18v2h2.1c.1.6.4 1.2.7 1.8l-1.5 1.5l1.4 1.4l1.5-1.5c.5.3 1.1.6 1.7.7V32h2v-2.1c.6-.1 1.2-.4 1.7-.7l1.5 1.5l1.4-1.4l-1.5-1.5c.4-.5.6-1.1.7-1.8H32v-2h-2.1c-.1-.6-.4-1.2-.7-1.8l1.5-1.5l-1.4-1.4l-1.5 1.5c-.5-.3-1.1-.6-1.7-.7V18zm.9 4c1.7 0 3 1.3 3 3s-1.3 3-3 3s-3-1.3-3-3s1.3-3 3-3m0 2a.9.9 0 0 0-.367.086a1.1 1.1 0 0 0-.32.227a1.1 1.1 0 0 0-.227.32A.9.9 0 0 0 24 25c0 .375.281.75.633.914A.9.9 0 0 0 25 26c.5 0 1-.5 1-1s-.5-1-1-1"/></svg>
                        <span class="displayOnOpen">Actualizacion de rol</span>
                    </label>

                <?php } ?>
                
                    <label class="sidebar-item">
                        <input type="radio" name="captura_1_1" data-src="./html/userSettings/changePassword.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 17v4m-2-1l4-2m-4 0l4 2m-9-3v4m-2-1l4-2m-4 0l4 2m12-3v4m-2-1l4-2m-4 0l4 2M9 6a3 3 0 1 0 6 0a3 3 0 0 0-6 0m-2 8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2"/></svg>
                        <span class="displayOnOpen">Cambiar Contraseña</span>
                    </label>

                </div>

            </div>

        </div>

        <div class="sidebar-footer">

            <div class="divDarkThemeBtn">
                <div class="darkThemeBtn">
                    <label>
                        <input type="checkbox" id="darkthemeController">
                        <svg viewBox="0 0 512 512" class="sun">
                            <g transform="translate(0 512) scale(.1 -.1)">
                                <path
                                    d="m2513 5105c-59-25-63-46-63-320 0-266 4-288 54-315 33-17 79-17 112 0 50 27 54 49 54 315 0 275-4 295-65 321-42 17-51 17-92-1z">
                                </path>
                                <path
                                    d="m754 4366c-28-28-34-41-34-77 0-42 3-45 188-231l187-188h47c39 0 52 5 77 31 26 25 31 38 31 77v47l-188 187c-186 185-189 188-231 188-36 0-49-6-77-34z">
                                </path>
                                <path
                                    d="m4058 4212-188-187v-47c0-39 5-52 31-77 25-26 38-31 77-31h46l188 188c186 186 188 188 188 231 0 36-6 49-34 77s-41 34-77 34c-42 0-45-3-231-188z">
                                </path>
                                <path
                                    d="m2440 4224c-453-50-760-192-1056-488-264-264-419-570-475-936-17-109-17-371 0-480 56-366 211-672 475-936s570-419 936-475c109-17 371-17 480 0 366 56 672 211 936 475 225 225 358 455 438 758 38 143 50 249 50 418 0 219-30 388-104 590-137 372-450 719-813 901-143 72-315 128-474 154-89 15-329 26-393 19zm335-235c305-46 582-186 805-409 567-567 567-1473 0-2040s-1473-567-2040 0-567 1473 0 2040c328 328 777 476 1235 409z">
                                </path>
                                <path
                                    d="m54 2651c-20-12-37-34-44-55-16-49 2-101 44-127 28-17 52-19 279-19 268 0 289 4 317 54 17 33 17 79 0 112-28 50-49 54-317 54-227 0-251-2-279-19z">
                                </path>
                                <path
                                    d="m4512 2657c-73-41-73-155 0-193 21-11 81-14 275-14 227 0 251 2 279 19 42 26 60 78 44 127-7 21-24 43-44 55-28 17-52 19-281 19-181-1-256-4-273-13z">
                                </path>
                                <path
                                    d="m908 1062c-185-186-188-189-188-231 0-36 6-49 34-77s41-34 77-34c43 0 45 2 231 188l188 188v46c0 39-5 52-31 77-25 26-38 31-77 31h-47l-187-188z">
                                </path>
                                <path
                                    d="m3901 1219c-26-25-31-38-31-77v-47l188-187c186-185 189-188 231-188 36 0 49 6 77 34s34 41 34 77c0 43-2 45-188 231l-188 188h-46c-39 0-52-5-77-31z">
                                </path>
                                <path
                                    d="m2540 663c-87-28-90-37-90-330 0-227 2-251 19-279 40-66 142-66 182 0 17 28 19 52 19 279 0 266-4 291-52 314-32 16-60 22-78 16z">
                                </path>
                            </g>
                        </svg>
                        <svg viewBox="0 0 512 512" class="moon">
                            <g transform="translate(0 512) scale(.1 -.1)">
                                <path
                                    d="m2090 5105c-248-51-443-118-659-226-514-256-909-652-1161-1163-94-191-139-311-185-490-127-500-110-999 51-1468 133-389 331-706 624-998 403-404 875-642 1460-736 147-24 529-24 693 0 539 78 981 283 1390 644 362 319 647 793 766 1270 46 186 56 256 42 299-22 71-80 116-151 117-73 1-104-19-181-116-307-390-733-627-1233-689-119-14-385-7-501 15-582 106-1066 469-1321 991-120 246-171 452-181 731-21 586 230 1126 695 1493 96 75 117 107 117 177 0 85-67 155-153 160-26 1-76-3-112-11zm110-149c0-2-26-23-57-47-81-60-254-230-325-318-213-264-353-573-415-916-22-126-25-508-5-625 62-346 195-651 395-910 72-93 228-250 327-329 266-213 571-349 930-413 117-20 499-17 625 5 343 62 652 202 916 415 88 71 258 244 318 325 24 32 46 56 48 54s-8-60-23-128c-127-606-501-1155-1027-1505-780-521-1798-535-2602-36-295 183-594 482-777 777-335 539-445 1180-308 1795 138 621 515 1158 1060 1511 136 88 374 201 530 253 148 49 390 106 390 92z">
                                </path>
                            </g>
                        </svg>
                    </label>
                    <span class="fake-body"></span>
                </div>
            </div>

            <a class="sidebar-item" href="logout.php">
                <svg width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M17 2H7C5.3 2 4 3.3 4 5v6h8.6l-2.3-2.3c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l4 4c.4.4.4 1 0 1.4l-4 4c-.4.4-1 .4-1.4 0s-.4-1 0-1.4l2.3-2.3H4v6c0 1.7 1.3 3 3 3h10c1.7 0 3-1.3 3-3V5c0-1.7-1.3-3-3-3" />
                </svg>
                <span class="displayOnOpen">Cerrar sesión</span>
            </a>


        </div>

    </aside>

    <main>

        <iframe id="iframeForms" src="" frameborder="0"></iframe>

    </main>

</body>

</html>