// Minimal impression tracker: when <img class="ad-img" data-ad-id="..."> becomes visible, POST to /ads/impression/{id}
(function () {
  if (!('IntersectionObserver' in window)) return;

  function reportImpression(id) {
    if (!id) return;
    try {
      fetch('/ads/impression/' + id, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content
        },
        credentials: 'same-origin'
      }).catch(function () { /* ignore */ });
    } catch (e) {}
  }

  var observed = new WeakMap();
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var img = entry.target;
        var adId = img.getAttribute('data-ad-id');
        if (adId && !observed.get(img)) {
          reportImpression(adId);
          observed.set(img, true);
        }
      }
    });
  }, { threshold: 0.5 });

  document.addEventListener('DOMContentLoaded', function () {
    var imgs = document.querySelectorAll('img.ad-img[data-ad-id]');
    imgs.forEach(function (img) { io.observe(img); });
  });
})();