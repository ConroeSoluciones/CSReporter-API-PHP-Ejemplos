<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

/**
 * Este ejemplo muestra la forma de realizar una consulta al webservice
 * de CSReporter. Además de mostrar cómo hacer la consulta, también se
 * describe cómo verificar el estado de la misma, para finalmente tener
 * el resumen de los resultados encontrados.
 */

// archivo autoload.php de Composer
require_once dirname(__FILE__) . '/../vendor/autoload.php';

use ConroeSoluciones\CSReporter\Impl\CSReporterImpl;
use ConroeSoluciones\CSReporter\ParametrosBuilder;
use ConroeSoluciones\CSReporter\StatusCFDI;
use ConroeSoluciones\CSReporter\TipoCFDI;

// la configuración necesaria para correr los ejemplos
$config = require dirname(__FILE__) . "/config.php";

// esto es necesario para evitar errores al realizar operaciones que involucran
// fechas
date_default_timezone_set("America/Mexico_City");

// las credenciales del contrato con ConroeSoluciones, únicamente sirven
// para validar el contrato y NO para la realización de consultas ante el
// portal del SAT
$csCredenciales = $config["csCredenciales"];

// la instancia de CSReporter encargada de realizar consultas, una misma
// instancia es capaz de manejar más de una consulta al WS de CSReporter
$csReporter = new CSReporterImpl($csCredenciales);

// credenciales a usar para el portal del SAT, puede cambiar para cada consulta,
// es decir que un CSReporter soporta múltiples consultas de RFCs distintos.
$satCredenciales = $config["satCredenciales"];

// este builder se utiliza para generar los Parametros requeridos para la 
// consulta
$paramsBuilder = new ParametrosBuilder();

// realiza la consulta, espera hasta que el servidor devuelva el UUID de ésta
$consulta = $csReporter->consultar($satCredenciales, $paramsBuilder
                ->fechaInicio("2016-01-01T00:00:00")
                ->fechaFin("2016-01-31T23:59:59")
                ->status(StatusCFDI::VIGENTE)
                ->tipo(TipoCFDI::EMITIDAS)
                ->build());

echo $consulta->getFolio() . "\n";

// espera hasta que la consulta haya terminado
while (!$consulta->isTerminada()) {
    echo $consulta->getStatus() . "\n";
    \sleep(5);
}

// una vez terminada, se puede verificar el resumen de la misma
echo $consulta->getStatus() . "\n";
echo "Total resultados: " . $consulta->getTotalResultados() . "\n";
echo "Total páginas: " . $consulta->getPaginas() . "\n";

// además de poder iterar las páginas con los resultados obtenidos
for ($i = 1; $i <= $consulta->getPaginas(); $i++) {
    $resultados = $consulta->getResultados($i);

    // hacer algo con los resultados obtenidos
}

// se debe llamar a este método para liberar los recursos que haya utilizado el
// CSReporter
$csReporter->close();
