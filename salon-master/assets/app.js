/* Salon Master front end. No libraries. Every animation is skipped when the visitor asks for reduced motion. */
(function () {
  var dl = (window.dataLayer = window.dataLayer || []);
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
  document.documentElement.classList.add('js');

  // Header: compact + shadow once the page scrolls
  var header = $('[data-header]');
  var onScroll = function () { if (header) header.classList.toggle('is-scrolled', window.scrollY > 24); };
  window.addEventListener('scroll', onScroll, { passive: true }); onScroll();

  // Mobile nav (CSS animates the open state)
  var toggle = $('[data-nav-toggle]'), nav = document.getElementById('site-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Scroll reveal: sections fade up as they enter; children of [data-stagger] follow one after another
  var revealables = $$('[data-reveal], [data-stagger] > *');
  $$('[data-stagger] > *').forEach(function (el, i) { el.style.setProperty('--d', (i % 8) * 90 + 'ms'); });
  if (reduce || !('IntersectionObserver' in window)) {
    revealables.forEach(function (el) { el.classList.add('is-in'); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });
    revealables.forEach(function (el) { io.observe(el); });
  }

  // Sticky "Book now" bar on phones, shown after the hero scrolls away
  var bar = $('[data-book-bar]'), hero = $('main > section');
  if (bar && hero && 'IntersectionObserver' in window) {
    new IntersectionObserver(function (e) { bar.classList.toggle('is-shown', !e[0].isIntersecting); }).observe(hero);
  }

  // Before / after slider: the range input sets --pos, CSS clips the "after" image to it
  $$('[data-before-after]').forEach(function (fig) {
    var range = $('.ba-range', fig), moved = false;
    range.addEventListener('input', function () {
      fig.style.setProperty('--pos', range.value + '%');
      if (!moved) { moved = true; dl.push({ event: 'before_after_used' }); }
    });
  });

  // Gallery lightbox: native <dialog>, Esc to close, arrow keys to browse
  var dialog = $('[data-lightbox-dialog]');
  if (dialog && dialog.showModal) {
    var shots = $$('[data-lightbox]'), img = $('[data-lightbox-img]', dialog), at = 0;
    var show = function (i) { at = (i + shots.length) % shots.length; img.src = shots[at].dataset.lightbox; };
    shots.forEach(function (b, i) { b.addEventListener('click', function () { show(i); dialog.showModal(); dl.push({ event: 'gallery_open', index: i + 1 }); }); });
    $('[data-lightbox-close]', dialog).addEventListener('click', function () { dialog.close(); });
    dialog.addEventListener('click', function (e) { if (e.target === dialog) dialog.close(); });
    dialog.addEventListener('keydown', function (e) { if (e.key === 'ArrowRight') show(at + 1); if (e.key === 'ArrowLeft') show(at - 1); });
  }

  // "Open now" badges from the location's hours, in the salon's own time zone (New Orleans = America/Chicago)
  var DAYS = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
  var tz = document.documentElement.dataset.salonTz || 'America/Chicago';
  var now = new Date(new Date().toLocaleString('en-US', { timeZone: tz }));
  var mins = now.getHours() * 60 + now.getMinutes();
  var inRange = function (spec, day) {        // "Tu-Fr", "Sa", "Su-Mo" (ranges can wrap past Saturday)
    var p = spec.split('-'), a = DAYS.indexOf(p[0]), b = DAYS.indexOf(p[1] || p[0]);
    if (a < 0 || b < 0) return false;
    return a <= b ? day >= a && day <= b : day >= a || day <= b;
  };
  $$('[data-open-badge]').forEach(function (el) {
    var open = false, label = 'Closed now';
    (JSON.parse(el.dataset.hours || '[]')).forEach(function (row) {
      var m = /^(\d{2}):(\d{2})-(\d{2}):(\d{2})$/.exec((row[1] || '').replace(/\s/g, ''));
      if (!m || !inRange(row[0], now.getDay())) return;
      var from = +m[1] * 60 + +m[2], to = +m[3] * 60 + +m[4];
      if (mins >= from && mins < to) { open = true; label = 'Open now · until ' + m[3] + ':' + m[4]; }
    });
    el.textContent = label;
    el.classList.remove('hidden');
    el.classList.add(open ? 'is-open' : 'is-closed');
  });

  // Service menu: section pills highlight the category you're reading
  var pills = $$('[data-menu-pills] a');
  if (pills.length && 'IntersectionObserver' in window) {
    var mark = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        pills.forEach(function (p) { p.classList.toggle('is-active', p.getAttribute('href') === '#' + e.target.id); });
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    $$('[data-menu-section]').forEach(function (s) { mark.observe(s); });
  }

  // Find your stylist: cards fade out/in as the filter changes
  var form = $('[data-stylist-filter]');
  if (form) {
    var cards = $$('[data-stylist-card]'), count = $('[data-stylist-count]', form);
    var apply = function (track) {
      var level = form.elements.level.value, loc = form.elements.location.value, shown = 0;
      cards.forEach(function (c) {
        var ok = (!level || (' ' + c.dataset.level + ' ').indexOf(' ' + level + ' ') > -1) && (!loc || c.dataset.location === loc);
        if (ok) shown++;
        if (ok && c.hidden) { c.hidden = false; c.classList.add('is-entering'); requestAnimationFrame(function () { requestAnimationFrame(function () { c.classList.remove('is-entering'); }); }); }
        if (!ok) c.hidden = true;
      });
      if (count) count.textContent = shown + (shown === 1 ? ' stylist' : ' stylists');
      if (track) dl.push({ event: 'stylist_filter', level: level || 'any', location_id: loc || 'any', results: shown });
    };
    form.addEventListener('change', function () { apply(true); });
    apply(false);
  }

  // GA4 events (GTM maps these to GA4 event tags)
  document.addEventListener('click', function (e) {
    var a = e.target.closest('a');
    if (!a) return;
    if (a.hasAttribute('data-salon-book')) {
      dl.push({ event: 'book_now_click', click_context: a.dataset.context || '', location_name: a.dataset.location || '', stylist_name: a.dataset.stylist || '', link_url: a.href });
    } else if (a.hasAttribute('data-salon-phone')) {
      dl.push({ event: 'phone_click', location_name: a.dataset.location || '' });
    } else if (a.hasAttribute('data-salon-directions')) {
      dl.push({ event: 'directions_click', location_name: a.dataset.location || '' });
    }
  });
})();
