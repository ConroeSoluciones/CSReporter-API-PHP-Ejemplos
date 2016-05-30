<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Este ejemplo muestra cómo buscar una consulta realizada anteriormente.
 * Además de mostrar cómo hacer la consulta, también se
 * describe cómo verificar el estado de la misma, para finalmente tener
 * el resumen de los resultados encontrados.
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

// muestra el status actual de la consulta
echo $consulta->getStatus() . "\n";

if ($consulta->isTerminada() && !$consulta->isFallo()) {
    echo "Total resultados: " . $consulta->getTotalResultados() . "\n";
    echo "Total páginas: " . $consulta->getPaginas() . "\n";
}

// se debe llamar a este método para liberar los recursos que haya utilizado el
// CSReporter
$csReporter->close();

