<?php
declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";
Testbench\Bootstrap::setup(__DIR__ . '/_temp', function (\Nette\Configurator $configurator): void {
  $configurator->addParameters([
    "appDir" => __DIR__,
    "tempDir" => __DIR__ . "/_temp",
    "debugMode" => false,
  ]);
  $configurator->addConfig(__DIR__ . "/tests.neon");
});
?>