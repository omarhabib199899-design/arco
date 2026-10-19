/* ARCO — site behaviour */
(function () {
  'use strict';

  /* ---- Mobile menu ---- */
  var burger = document.getElementById('burger');
  var menu   = document.getElementById('menu');
  if (burger && menu) {
    burger.addEventListener('click', function () {
      menu.classList.toggle('open');
      burger.classList.toggle('open');
    });
    menu.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') { menu.classList.remove('open'); burger.classList.remove('open'); }
    });
  }

  /* ---- Header shadow on scroll ---- */
  var header = document.getElementById('header');
  if (header) {
    var onScroll = function () { header.classList.toggle('scrolled', window.scrollY > 8); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ---- Reveal on scroll ---- */
  var items = document.querySelectorAll('.reveal');
  if (items.length) {
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en, i) {
          if (en.isIntersecting) {
            setTimeout(function () { en.target.classList.add('in'); }, i * 70);
            io.unobserve(en.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
      items.forEach(function (el) { io.observe(el); });
    } else {
      items.forEach(function (el) { el.classList.add('in'); });
    }
  }

  /* ---- Projects filter + search ---- */
  var filterBtns = document.querySelectorAll('[data-filter]');
  var searchBox  = document.getElementById('prjSearch');
  var rows       = document.querySelectorAll('[data-row]');
  var cards      = document.querySelectorAll('[data-card]');
  var emptyRow   = document.getElementById('emptyRow');
  var activeF    = 'all';

  function applyFilter() {
    var q = (searchBox && searchBox.value || '').trim().toLowerCase();
    var shown = 0;

    cards.forEach(function (c) {
      var ok = (activeF === 'all' || c.getAttribute('data-region') === activeF);
      c.style.display = ok ? '' : 'none';
    });

    rows.forEach(function (r) {
      var okR = (activeF === 'all' || r.getAttribute('data-region') === activeF);
      var okQ = !q || r.textContent.toLowerCase().indexOf(q) !== -1;
      var ok  = okR && okQ;
      r.style.display = ok ? '' : 'none';
      if (ok) shown++;
    });

    if (emptyRow) emptyRow.style.display = shown ? 'none' : '';
  }

  filterBtns.forEach(function (b) {
    b.addEventListener('click', function () {
      filterBtns.forEach(function (x) { x.classList.remove('active'); });
      b.classList.add('active');
      activeF = b.getAttribute('data-filter');
      applyFilter();
    });
  });
  if (searchBox) searchBox.addEventListener('input', applyFilter);

  /* ---- Booking: block past dates & the weekly off-day ---- */
  var dateInput = document.getElementById('pref_date');
  if (dateInput) {
    var today = new Date();
    var pad = function (n) { return (n < 10 ? '0' : '') + n; };
    dateInput.min = today.getFullYear() + '-' + pad(today.getMonth() + 1) + '-' + pad(today.getDate());
    var max = new Date(today.getTime() + 120 * 864e5);
    dateInput.max = max.getFullYear() + '-' + pad(max.getMonth() + 1) + '-' + pad(max.getDate());

    var offDay = parseInt(dateInput.getAttribute('data-offday') || '5', 10);
    var warn   = document.getElementById('dateWarn');
    dateInput.addEventListener('change', function () {
      if (!dateInput.value) { if (warn) warn.style.display = 'none'; return; }
      var d = new Date(dateInput.value + 'T00:00:00');
      var bad = d.getDay() === offDay;
      if (warn) warn.style.display = bad ? 'block' : 'none';
      if (bad) dateInput.value = '';
    });
  }

  /* ---- Counters ---- */
  var counters = document.querySelectorAll('[data-count]');
  if (counters.length && 'IntersectionObserver' in window) {
    var co = new IntersectionObserver(function (es) {
      es.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target, target = parseInt(el.getAttribute('data-count'), 10), cur = 0;
        var step = Math.max(1, Math.round(target / 45));
        var tick = setInterval(function () {
          cur += step;
          if (cur >= target) { cur = target; clearInterval(tick); }
          el.textContent = cur + (el.getAttribute('data-suffix') || '');
        }, 28);
        co.unobserve(el);
      });
    }, { threshold: 0.4 });
    counters.forEach(function (el) { co.observe(el); });
  }

  /* ---- Approvals: filter + lightbox ---- */
  var apvCards = Array.prototype.slice.call(document.querySelectorAll('[data-apv-card]'));

  if (apvCards.length) {
    var apvBtns  = document.querySelectorAll('[data-apv-filter]');
    var apvEmpty = document.getElementById('apvEmpty');
    var apvGroup = 'all';
    var apvShown = apvCards.slice();

    var apvApply = function (force) {
      apvShown = [];
      apvCards.forEach(function (c) {
        var ok = (apvGroup === 'all' || c.getAttribute('data-apv-group') === apvGroup);
        c.style.display = ok ? '' : 'none';
        if (ok) { apvShown.push(c); if (force) c.classList.add('in'); }
      });
      if (apvEmpty) apvEmpty.style.display = apvShown.length ? 'none' : '';
    };

    apvBtns.forEach(function (b) {
      b.addEventListener('click', function () {
        apvBtns.forEach(function (x) { x.classList.remove('active'); });
        b.classList.add('active');
        apvGroup = b.getAttribute('data-apv-filter');
        apvApply(true);
      });
    });
    apvApply(false);

    var lb = document.getElementById('apvLb');
    if (lb) {
      var lbImg   = document.getElementById('lbImg');
      var lbTitle = document.getElementById('lbTitle');
      var lbDesc  = document.getElementById('lbDesc');
      var lbFull  = document.getElementById('lbFull');
      var lbCount = document.getElementById('lbCount');
      var lbList  = [];
      var lbIdx   = 0;

      var lbShow = function () {
        var btn = lbList[lbIdx] && lbList[lbIdx].querySelector('[data-apv-open]');
        if (!btn) return;
        var src = btn.getAttribute('data-apv-open');
        lbImg.src        = src;
        lbImg.alt        = btn.getAttribute('data-apv-cap') || '';
        lbTitle.textContent = btn.getAttribute('data-apv-cap') || '';
        lbDesc.textContent  = btn.getAttribute('data-apv-desc') || '';
        lbFull.href      = src;
        lbCount.textContent = (lbIdx + 1) + ' / ' + lbList.length;
      };

      var lbOpen = function (card) {
        lbList = apvShown.slice();
        lbIdx  = lbList.indexOf(card);
        if (lbIdx < 0) { lbList = [card]; lbIdx = 0; }
        lbShow();
        lb.hidden = false;
        document.body.classList.add('lb-open');
      };

      var lbClose = function () {
        lb.hidden = true;
        lbImg.src = '';
        document.body.classList.remove('lb-open');
      };

      var lbStep = function (d) {
        if (lbList.length < 2) return;
        lbIdx = (lbIdx + d + lbList.length) % lbList.length;
        lbShow();
      };

      apvCards.forEach(function (card) {
        var btn = card.querySelector('[data-apv-open]');
        if (btn) btn.addEventListener('click', function () { lbOpen(card); });
      });

      document.getElementById('lbClose').addEventListener('click', lbClose);
      document.getElementById('lbPrev').addEventListener('click', function () { lbStep(-1); });
      document.getElementById('lbNext').addEventListener('click', function () { lbStep(1); });
      lb.addEventListener('click', function (e) { if (e.target === lb || e.target.classList.contains('lb-stage')) lbClose(); });
      document.addEventListener('keydown', function (e) {
        if (lb.hidden) return;
        if (e.key === 'Escape')     lbClose();
        if (e.key === 'ArrowRight') lbStep(1);
        if (e.key === 'ArrowLeft')  lbStep(-1);
      });
    }
  }
})();
