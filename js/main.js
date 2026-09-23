(function () {
  'use strict';

  /* ============================================================
     MENU MOBILNE
     ============================================================ */
  var navToggle = document.getElementById('navToggle');
  var navlinks = document.getElementById('navlinks');

  if (navToggle && navlinks) {
    navToggle.addEventListener('click', function () {
      var isOpen = navlinks.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', String(isOpen));
    });

    navlinks.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        navlinks.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ============================================================
     RAMÓWKA — przełączanie dni bez przeładowania strony
     ============================================================ */
  var ramowkaBaseUrl = 'https://radioeuforia.panelradiowy.pl/embed.php?script=ramowka2&dzien=';
  var ramowkaFrame = document.getElementById('ramowka-frame');
  var dayButtons = document.querySelectorAll('#days button');

  function setDay(day) {
    if (!ramowkaFrame) return;
    ramowkaFrame.src = ramowkaBaseUrl + day;
    dayButtons.forEach(function (b) {
      b.classList.toggle('active', b.dataset.day === String(day));
    });
  }

  dayButtons.forEach(function (b) {
    b.addEventListener('click', function () { setDay(b.dataset.day); });
  });

  if (ramowkaFrame) {
    var jsDay = new Date().getDay(); // 0 = niedziela
    var today = jsDay === 0 ? 7 : jsDay;
    setDay(today);
  }

  /* ============================================================
     ODTWARZACZ NA ŻYWO
     Strumień ten sam, którego używa obecna produkcyjna strona
     (patrz stary plik player.js) — dzięki temu słuchanie działa
     bezpośrednio na stronie, bez przechodzenia na osobną podstronę.
     ============================================================ */
  var audio = document.getElementById('streamAudio');
  var STREAM_URL = 'https://s3.slotex.pl/shoutcast/7510/stream?sid=1';
  var volumeSlider = document.getElementById('volumeSlider');
  var statusEl = document.querySelector('.js-player-status');
  var playToggles = document.querySelectorAll('.js-audio-toggle');
  var eqEls = document.querySelectorAll('.js-eq');
  var liveDots = document.querySelectorAll('.js-live-dot');

  if (audio) {
    audio.src = STREAM_URL;
    audio.load();
    audio.volume = volumeSlider ? parseFloat(volumeSlider.value) : 0.8;
  }

  function setPlayingState(isPlaying) {
    playToggles.forEach(function (btn) {
      btn.classList.toggle('is-playing', isPlaying);
      btn.setAttribute('aria-pressed', String(isPlaying));
      btn.setAttribute('aria-label', isPlaying ? 'Zatrzymaj Radio Euforia' : 'Odtwórz Radio Euforia na żywo');
    });
    eqEls.forEach(function (eq) { eq.classList.toggle('eq--playing', isPlaying); });
    liveDots.forEach(function (dot) { dot.classList.toggle('is-live', isPlaying); });
  }

  function showStatus(message) {
    if (!statusEl) return;
    statusEl.textContent = message;
    window.clearTimeout(showStatus._t);
    showStatus._t = window.setTimeout(function () {
      statusEl.textContent = '';
    }, 5000);
  }

  function togglePlay() {
    if (!audio) return;
    if (audio.paused) {
      if (audio.error) {
        // Wcześniejsza próba wczytania strumienia zakończyła się błędem
        // (np. chwilowy problem sieciowy) — dajemy realną szansę na retry.
        audio.load();
      }
      audio.play().catch(function () {
        showStatus('Nie można połączyć się ze strumieniem. Spróbuj ponownie.');
      });
    } else {
      audio.pause();
    }
  }

  playToggles.forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault(); // dla #heroPlayBtn (link z awaryjnym href)
      togglePlay();
    });
  });

  if (audio) {
    audio.addEventListener('playing', function () { setPlayingState(true); });
    audio.addEventListener('pause', function () { setPlayingState(false); });
    audio.addEventListener('ended', function () { setPlayingState(false); });
    // Uwaga: audio.load() przy ustawianiu .src potrafi wywołać zdarzenie
    // "error", zanim ktokolwiek kliknie play (np. przy problemach z siecią
    // w tle). Nie pokazujemy wtedy komunikatu — użytkownik nic nie klikał,
    // więc nie ma o czym go informować. Komunikat o błędzie pojawia się
    // WYŁĄCZNIE w togglePlay(), czyli w reakcji na realną próbę kliknięcia.
    audio.addEventListener('error', function () {
      setPlayingState(false);
    });
  }

  if (volumeSlider && audio) {
    volumeSlider.addEventListener('input', function () {
      audio.volume = parseFloat(volumeSlider.value);
    });
    // Zabezpieczenie, żeby kliknięcia/przeciąganie suwaka nie odpalały
    // innych zdarzeń na pigułce odtwarzacza.
    ['click', 'mousedown', 'touchstart'].forEach(function (evt) {
      volumeSlider.addEventListener(evt, function (e) { e.stopPropagation(); });
    });
  }

  /* ============================================================
     PREZENTER / GATUNEK NA ŻYWO
     Odpytuje własny endpoint prezenter.php (ten sam serwer = zero
     problemów z CORS). Strona renderuje się od razu z tekstem
     domyślnym, a ten fetch tylko go aktualizuje w tle — dzięki
     temu wolne/zablokowane połączenie do zewnętrznego serwera
     statystyk nigdy nie spowalnia wczytywania strony.
     ============================================================ */
  var presenterEls = document.querySelectorAll('.js-presenter');

  function refreshPresenter() {
    if (!presenterEls.length) return;
    fetch('prezenter.php', { cache: 'no-store' })
      .then(function (r) { return r.ok ? r.text() : Promise.reject(r.status); })
      .then(function (text) {
        var clean = text.trim();
        if (!clean) return;
        presenterEls.forEach(function (el) { el.textContent = clean; });
      })
      .catch(function () {
        /* cichy fallback — zostaje ostatnia znana / domyślna wartość */
      });
  }

  refreshPresenter();
  setInterval(refreshPresenter, 30000);
})();
