<?php
/**
 * Radio Euforia — strona główna.
 * Wymaga serwera z PHP (np. `php -S localhost:8000` w tym folderze,
 * albo Apache/Nginx z PHP, XAMPP/MAMP). Samo otwarcie pliku podwójnym
 * kliknięciem w przeglądarce NIE wykona kodu PHP.
 */
$rokBiezacy = date('Y');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Radio Euforia — nadajemy dla ludzi</title>
<meta name="description" content="Nowoczesne Radio Internetowe, stworzone przez ludzi, dla ludzi. Zapraszamy do wspólnej zabawy, dołącz do nas już dziś!">
<link rel="icon" href="img/favicon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;800;900&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
  <nav class="wrap">
    <a class="brand" href="#home">
      <img src="img/IMG_2017.webp" alt="Radio Euforia">
    </a>

    <div class="navlinks" id="navlinks">
      <a href="#ramowka">Ramówka</a>
      <a href="https://radioeuforia.panelradiowy.pl/embed.php?script=ekipa" target="_blank" rel="noopener noreferrer">Prezenterzy</a>
      <a href="#linki">Zapraszamy</a>
      <a href="https://radioeuforia.pl/czat" target="_blank" rel="noopener noreferrer">Czat</a>
    </div>

    <div class="nav-right">
      <div class="player" id="player">
        <button type="button" class="player__toggle js-audio-toggle" id="navPlayToggle" aria-pressed="false" aria-label="Odtwórz Radio Euforia na żywo">
          <svg class="icon-play" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
          <svg class="icon-pause" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6 5h4v14H6zM14 5h4v14h-4z"/></svg>
        </button>
        <div class="player__info">
          <span class="player__dot js-live-dot" aria-hidden="true"></span>
          <span class="player__text">
            <span class="player__label">Na żywo</span>
            <span class="player__presenter js-presenter">Radio Euforia</span>
          </span>
        </div>
        <div class="player__volume">
          <input type="range" id="volumeSlider" min="0" max="1" step="0.05" value="0.8" aria-label="Głośność odtwarzacza">
        </div>
        <p class="player__status js-player-status" aria-live="polite"></p>
      </div>

      <button class="nav-toggle" id="navToggle" aria-label="Otwórz menu" aria-expanded="false" aria-controls="navlinks">
        <svg class="icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        <svg class="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="5" y1="5" x2="19" y2="19"/><line x1="19" y1="5" x2="5" y2="19"/></svg>
      </button>
    </div>
  </nav>
</header>

<audio id="streamAudio" preload="none"></audio>
<noscript>
  <p style="text-align:center;padding:10px;background:#20103b;color:#f6f1fb">
    Aby słuchać radia bezpośrednio na stronie, włącz JavaScript — albo
    <a href="https://radioeuforia.panelradiowy.pl/radio.php?script" style="color:#ff3e7a">otwórz odtwarzacz w nowej karcie</a>.
  </p>
</noscript>

<section class="hero" id="home">
  <div class="wrap">
    <div class="eq js-eq"><span></span><span></span><span></span><span></span><span></span><span></span></div>
    <h1>Radio <em>Euforia</em></h1>
    <p>Jedyne takie radio w sieci — nadajemy dla ludzi, tworzone przez ludzi. Muzyka, prezenterzy na żywo i ekipa, która czeka na ciebie w czacie każdego dnia.</p>
    <p class="hero__live"><span class="player__dot js-live-dot" aria-hidden="true"></span> Teraz gra: <strong class="js-presenter">Radio Euforia</strong></p>
    <div class="hero-actions">
      <a class="btn btn-primary js-audio-toggle" id="heroPlayBtn" href="https://radioeuforia.panelradiowy.pl/radio.php?script" target="_blank" rel="noopener noreferrer" aria-pressed="false">
        <svg class="icon-play" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
        <svg class="icon-pause" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6 5h4v14H6zM14 5h4v14h-4z"/></svg>
        Słuchaj live
      </a>
      <a class="btn btn-ghost" href="https://play.google.com/store/apps/details?id=com.panelradiowy" target="_blank" rel="noopener noreferrer">Pobierz aplikację</a>
      <a class="btn btn-ghost" href="https://radioeuforia.panelradiowy.pl/embed.php?script=pozdrowienia" target="_blank" rel="noopener noreferrer">Wyślij pozdrowienia</a>
    </div>
  </div>
</section>

<section class="ramowka" id="ramowka">
  <div class="wrap">
    <div class="section-head">
      <h2>Ramówka</h2>
      <span>Wybierz dzień tygodnia</span>
    </div>
    <div class="days" id="days">
      <button data-day="1">Poniedziałek</button>
      <button data-day="2">Wtorek</button>
      <button data-day="3">Środa</button>
      <button data-day="4">Czwartek</button>
      <button data-day="5">Piątek</button>
      <button data-day="6">Sobota</button>
      <button data-day="7">Niedziela</button>
    </div>
    <div class="frame-shell">
      <iframe id="ramowka-frame" title="Ramówka Radia Euforia" loading="lazy"></iframe>
    </div>
  </div>
</section>

<section class="linki" id="linki">
  <div class="wrap">
    <div class="section-head">
      <h2>Bądź na bieżąco</h2>
      <span>Wszystko w jednym miejscu</span>
    </div>
    <div class="linklist">
      <a class="linkrow" href="https://radioeuforia.panelradiowy.pl/radio.php?script" target="_blank" rel="noopener noreferrer">
        <div><div class="title">Pełny odtwarzacz</div><div class="desc">Rozbudowany panel z playerem w osobnej karcie</div></div>
        <span class="go">↗</span>
      </a>
      <a class="linkrow" href="https://radioeuforia.panelradiowy.pl/embed.php?script=ekipa" target="_blank" rel="noopener noreferrer">
        <div><div class="title">Prezenterzy</div><div class="desc">Poznaj ekipę, która prowadzi audycje na żywo</div></div>
        <span class="go">↗</span>
      </a>
      <a class="linkrow" href="https://radioeuforia.panelradiowy.pl/embed.php?script=lista" target="_blank" rel="noopener noreferrer">
        <div><div class="title">Lista przebojów</div><div class="desc">Najczęściej grane utwory ostatnich dni</div></div>
        <span class="go">↗</span>
      </a>
      <a class="linkrow" href="https://radioeuforia.panelradiowy.pl/embed.php?script=rekrutacja" target="_blank" rel="noopener noreferrer">
        <div><div class="title">Rekrutacja</div><div class="desc">Chcesz prowadzić audycje? Dołącz do ekipy</div></div>
        <span class="go">↗</span>
      </a>
      <a class="linkrow" href="https://radioeuforia.panelradiowy.pl/" target="_blank" rel="noopener noreferrer">
        <div><div class="title">Panel prezentera</div><div class="desc">Logowanie dla prowadzących</div></div>
        <span class="go">↗</span>
      </a>
      <a class="linkrow" href="https://radioeuforia.pl/czat" target="_blank" rel="noopener noreferrer">
        <div><div class="title">Czat zapasowy</div><div class="desc">Gdy główny czat nie działa, jesteśmy tu</div></div>
        <span class="go">↗</span>
      </a>
      <a class="linkrow" href="https://www.facebook.com/profile.php?id=61554288802486" target="_blank" rel="noopener noreferrer">
        <div><div class="title">Fanpage</div><div class="desc">Nowości i kulisy na Facebooku</div></div>
        <span class="go">↗</span>
      </a>
    </div>
  </div>
</section>

<footer>
  <div class="wrap footer__inner">
    <div class="footer__grid">
      <div class="footer__col">
        <div class="footer__brand">
          <img src="img/IMG_2017.webp" alt="Radio Euforia">
        </div>
        <p class="footer__tag">Nowoczesne Radio Internetowe, stworzone przez ludzi, dla ludzi. Zapraszamy do wspólnej zabawy, dołącz do nas już dziś!</p>
        <div class="footer__social">
          <a href="https://www.facebook.com/profile.php?id=61554288802486" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5H16l.5-3H13.5V8.5c0-.9.25-1.5 1.55-1.5H16.5V4.3C16.2 4.26 15.2 4.17 14 4.17c-2.4 0-4 1.47-4 4.16V10.5H7.5v3H10V21h3.5z"/></svg>
          </a>
          <a href="https://play.google.com/store/apps/details?id=com.panelradiowy" target="_blank" rel="noopener noreferrer" aria-label="Aplikacja na Androida">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6 3.5c-.3.2-.5.5-.5.9v15.2c0 .4.2.7.5.9l9.9-8.5L6 3.5z"/></svg>
          </a>
        </div>
      </div>

      <div class="footer__col">
        <h3>Menu</h3>
        <ul class="footer__links">
          <li><a href="https://radioeuforia.panelradiowy.pl/radio.php?script" target="_blank" rel="noopener noreferrer">Słuchaj nas w playerze</a></li>
          <li><a href="https://radioeuforia.panelradiowy.pl/embed.php?script=pozdrowienia" target="_blank" rel="noopener noreferrer">Pozdrowienia</a></li>
          <li><a href="https://radioeuforia.panelradiowy.pl/embed.php?script=ekipa" target="_blank" rel="noopener noreferrer">Prezenterzy</a></li>
          <li><a href="https://radioeuforia.panelradiowy.pl/" target="_blank" rel="noopener noreferrer">Panel Prezentera</a></li>
          <li><a href="https://radioeuforia.panelradiowy.pl/embed.php?script=rekrutacja" target="_blank" rel="noopener noreferrer">Rekrutacja</a></li>
          <li><a href="https://radioeuforia.pl/czat" target="_blank" rel="noopener noreferrer">Czat zapasowy</a></li>
        </ul>
      </div>

      <div class="footer__col">
        <h3>Nadawanie zgodne z prawem</h3>
        <div class="footer__legal">
          <strong>ZAIKS</strong>
          Odtwarzane utwory są nadawane na podstawie licencji ZAIKS — wspieramy twórców i nadajemy legalnie.
        </div>
      </div>
    </div>

    <div class="footer__bottom">
      <p>Created by <span class="lillie">Lillie ♡</span> and <span class="eric">Eryk</span> &copy; <?= htmlspecialchars($rokBiezacy, ENT_QUOTES, 'UTF-8') ?> Radio Euforia</p>
      <a class="footer__totop" href="#home">↑ Do góry</a>
    </div>
  </div>
</footer>

<script src="js/main.js"></script>
</body>
</html>
