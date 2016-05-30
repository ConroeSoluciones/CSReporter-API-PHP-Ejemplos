<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Este ejemplo muestra cómo descargar un XML individual. Esto puede realizarse
 * si se conoce el UUID del CFDI a descargar.
 */

// esto es necesario para evitar errores al realizar operaciones que involucran
// fechas
date_default_timezone_set("America/Mexico_City");

// archivo autoload.php de Composer
require_once dirname(__FILE__) . '/../vendor/autoload.php';

use ConroeSoluciones\CSReporter\Impl\CSReporterImpl;

// la configuración necesaria para correr los ejemplos
$config = require dirname(__FILE__) . "/../config.php";

// las credenciales del contrato con ConroeSoluciones, únicamente sirven
// para validar el contrato y NO para la realización de consultas ante el
// portal del SAT
$csCredenciales = $config["csCredenciales"];

// la instancia de CSReporter encargada de realizar consultas, una misma
// instancia es capaz de manejar más de una consulta al WS de CSReporter
$csReporter = new CSReporterImpl($csCredenciales);

// el folio de una consulta que ya ha sido realizada
$folio = $config["consultaFolio"];

// busca la consulta en el WS de CSReporter, espera hasta que encuentre un
// resultado
$consulta = $csReporter->buscar($folio);

// debe estar terminada la consulta, sin fallo, para poder acceder a los 
// resultados
if ($consulta->isTerminada() && !$consulta->isFallo()) {

    if (!$consulta->hasResultados()) {
        die("La consulta debe tener por lo menos un resultado.");
    }

    // obtén el primer resultado de la consulta
    $cfdiMeta = $consulta->getResultados(1)[0];

    // el XML se obtiene con el folio del CFDI, el CFDI debe ser un resultado
    // de la consulta, de lo contrario se generará una excepción
    $xml = $consulta->getCFDIXML($cfdiMeta->folio);
    
    echo $xml;
}

// se debe llamar a este método para liberar los recursos que haya utilizado el
// CSReporter
$csReporter->close();
