<?php

use ConroeSoluciones\CSReporter\Credenciales;

/* 
 * Copyright 2016 NueveBit, todos los derechos reservados.
 */

return array(
    // contrato con ConroeSoluciones
    "csCredenciales" => new Credenciales("RFC"),
    // credenciales de acceso al portal CFDI del SAT
    "satCredenciales" => new Credenciales("RFC", "pass"),
    // folio conocido para realizar búsquedas en los ejemplos
    "consultaFolio" => "",
);
