<?php
/**
 * Lekki endpoint AJAX odpytywany przez js/main.js co 30 sekund.
 * Zwraca czysty tekst (nazwę prezentera/gatunku), zawsze bezpiecznie —
 * nigdy nie zwraca błędu PHP, żeby nie psuć działania odtwarzacza.
 */
declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: no-store');

require __DIR__ . '/inc/functions.php';

echo htmlspecialchars(pobierzPrezentera(), ENT_QUOTES, 'UTF-8');
