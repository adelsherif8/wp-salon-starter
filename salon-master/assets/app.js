/* Salon Master front end: mobile nav, "find your stylist" filter, GA4 events via the GTM dataLayer. */
(function () {
  var dl = (window.dataLayer = window.dataLayer || []);

  // Mobile nav
  var toggle = document.querySelector('[data-nav-toggle]');
  var nav = document.getElementById('site-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Find your stylist: show cards matching the chosen level and location
  var form = document.querySelector('[data-stylist-filter]');
  if (form) {
    var cards = Array.prototype.slice.call(document.querySelectorAll('[data-stylist-card]'));
    var count = form.querySelector('[data-stylist-count]');
    var apply = function () {
      var level = form.elements.level.value, loc = form.elements.location.value, shown = 0;
      cards.forEach(function (c) {
        var ok = (!level || (' ' + c.dataset.level + ' ').indexOf(' ' + level + ' ') > -1) && (!loc || c.dataset.location === loc);
        c.hidden = !ok;
        if (ok) shown++;
      });
      if (count) count.textContent = shown + (shown === 1 ? ' stylist' : ' stylists');
      dl.push({ event: 'stylist_filter', level: level || 'any', location_id: loc || 'any', results: shown });
    };
    form.addEventListener('change', apply);
    apply();
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
