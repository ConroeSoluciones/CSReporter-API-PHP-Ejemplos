<?php

/*
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

require_once dirname(__FILE__) . '/vendor/autoload.php';

use ConroeSoluciones\CSReporter\Credenciales;
use ConroeSoluciones\CSReporter\Impl\CSReporterImpl;
use ConroeSoluciones\CSReporter\ParametrosBuilder;
use ConroeSoluciones\CSReporter\StatusCFDI;
use ConroeSoluciones\CSReporter\TipoCFDI;

date_default_timezone_set("America/Mexico_City");

$csCredenciales = new Credenciales("XAAA010101AAA", "");
var_dump($csCredenciales);
$csReporter = new CSReporterImpl($csCredenciales);

$satCredenciales = new Credenciales("XAAA010101AAA", "");
$paramsBuilder = new ParametrosBuilder();
$consulta = $csReporter->consultar($satCredenciales, $paramsBuilder
                ->fechaInicio("2016-01-01T00:00:00")
                ->fechaFin("2016-01-31T23:59:59")
                ->status(StatusCFDI::VIGENTE)
                ->tipo(TipoCFDI::EMITIDAS)
                ->build());

echo $consulta->getFolio();
echo $consulta->getStatus();

// se debe llamar a este método para liberar los recursos que haya utilizado el
// CSReporter
$csReporter->close();
