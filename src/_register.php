<?php

declare(strict_types=1);

use OpenTelemetry\Contrib\Instrumentation\Laravel\LaravelInstrumentation;
use OpenTelemetry\SDK\Sdk;

// 加载环境变量
$dotenv = Dotenv\Dotenv::createMutable(getcwd());
$env    = $dotenv->safeLoad();

// 检测是否启用
if (!isset($env['OTEL_ENABLED']) || $env['OTEL_ENABLED'] !== 'true') {
    return;
}

if (class_exists(Sdk::class) && Sdk::isInstrumentationDisabled(LaravelInstrumentation::NAME) === true) {
    return;
}

if (extension_loaded('opentelemetry') === false) {
    trigger_error('The opentelemetry extension must be loaded in order to autoload the OpenTelemetry Laravel auto-instrumentation', E_USER_WARNING);

    return;
}

LaravelInstrumentation::register();
