(function () {
  var bar = document.getElementById('category-bar');
  var pills = document.querySelectorAll('.pill-btn');
  var stickyThreshold = 320;
  var activeCat = null;

  // Sticky category bar
  function onScroll() {
    if (window.scrollY > stickyThreshold) {
      bar.classList.add('sticky');
    } else {
      bar.classList.remove('sticky');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Pill button click -> scroll to product
  pills.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var targetId = btn.getAttribute('data-target');
      var cat = btn.getAttribute('data-cat');
      var el = document.getElementById(targetId);
      if (el) {
        var offset = 100;
        var top = el.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top: top, behavior: 'smooth' });
      }
      // Update active state
      pills.forEach(function (p) { p.classList.remove('active'); });
      btn.classList.add('active');
      activeCat = cat;
    });
  });

  // FAQ toggle
  window.toggleFaq = function (btn) {
    var item = btn.closest('.faq-item');
    item.classList.toggle('open');
  };
})();
