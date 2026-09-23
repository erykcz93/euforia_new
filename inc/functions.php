<?php
/**
 * Wspólne funkcje pomocnicze Radia Euforia.
 */

/**
 * Pobiera nazwę aktualnego prezentera / gatunku ze statystyk Shoutcast.
 *
 * Uwaga: w logach błędów starej strony (error_log) widać, że hosting
 * wielokrotnie odrzucał połączenie do s3.slotex.pl:7510 ("Connection
 * refused") — prawdopodobnie hosting blokuje wychodzące połączenia na
 * tym porcie. Dlatego funkcja ma krótki timeout i zawsze bezpiecznie
 * wraca do wartości domyślnej zamiast wyświetlać błąd.
 */
function pobierzPrezentera(string $domyslny = 'Radio Euforia'): string
{
    $url = 'https://s3.slotex.pl:7510/stats?sid=1';

    $context = stream_context_create([
        'http' => [
            'timeout'       => 2.5,
            'ignore_errors' => true,
        ],
    ]);

    $odpowiedz = @file_get_contents($url, false, $context);
    if ($odpowiedz === false || trim($odpowiedz) === '') {
        return $domyslny;
    }

    $xml = @simplexml_load_string($odpowiedz);
    if ($xml === false || !isset($xml->SERVERGENRE)) {
        return $domyslny;
    }

    $genre = trim((string) $xml->SERVERGENRE);
    $pomijane = ['', 'rdm', 'various', 'radio', 'no name', 'unknown'];

    if (in_array(mb_strtolower($genre), $pomijane, true)) {
        return $domyslny;
    }

    return $genre;
}
