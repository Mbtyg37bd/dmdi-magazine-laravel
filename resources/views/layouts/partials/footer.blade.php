<footer class="site-footer mt-8">
  <div class="container footer-top py-6">
    <div class="row align-items-start">
      <div class="col-12 col-lg-3 mb-4 mb-lg-0">
        <!-- Brand -->
        <div class="footer-brand mb-3 d-flex align-items-center gap-3">
          <a href="{{ url('/' . (app()->getLocale() ?? 'id')) }}" class="d-inline-block logo-wrap" aria-label="DMDI home">
            <img src="{{ asset('images/dmdi-logo.png') }}" alt="DMDI" class="footer-logo"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';" />
            <span class="logo-text" style="display:none; font-weight:700; letter-spacing:0.08em;">DMDI</span>
          </a>
        </div>

        <!-- SOCIAL ICONS: local SVG files (single row) -->
        <div class="footer-social mb-3" aria-label="Social links">
          <a href="https://x.com/your_username" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="X">
            <img src="{{ asset('images/x.svg') }}" alt="X" class="social-icon-img" />
          </a>

          <a href="https://www.tiktok.com/@your_tiktok_username" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="TikTok">
            <img src="{{ asset('images/tiktok.svg') }}" alt="TikTok" class="social-icon-img" />
          </a>

          <a href="https://www.youtube.com/your_channel" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="YouTube">
            <img src="{{ asset('images/youtube.svg') }}" alt="YouTube" class="social-icon-img" />
          </a>

          <a href="https://www.facebook.com/your_page" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Facebook">
            <img src="{{ asset('images/facebook.svg') }}" alt="Facebook" class="social-icon-img" />
          </a>

          <a href="https://www.instagram.com/your_username" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Instagram">
            <img src="{{ asset('images/instagram.svg') }}" alt="Instagram" class="social-icon-img" />
          </a>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-9">
        <div class="row">
          <div class="col-6 col-md-4">
            <ul class="footer-links list-unstyled">
              <li><a href="#">{{ __('footer.newsletter') }}</a></li>
              <li><a href="#">{{ __('footer.contact') }}</a></li>
              <li><a href="#">{{ __('footer.subscribe') }}</a></li>
              <li class="mt-3">
                <img src="{{ asset('images/hearst-logo.png') }}" alt="Hearst" class="hearst-logo"
                     onerror="this.style.display='none';" />
              </li>
            </ul>
          </div>

          <div class="col-6 col-md-4">
            <ul class="footer-links list-unstyled">
              <li><a href="#">{{ __('footer.about') }}</a></li>
              <li><a href="#">{{ __('footer.community') }}</a></li>
              <li><a href="#">{{ __('footer.other_subs') }}</a></li>
            </ul>
          </div>

          <div class="col-6 col-md-4">
            <ul class="footer-links list-unstyled">
              <li><a href="#">{{ __('footer.media_kit') }}</a></li>
              <li><a href="#">{{ __('footer.advertise') }}</a></li>
              <li><a href="#">{{ __('footer.events') }}</a></li>
            </ul>
          </div>

          <div class="col-6 col-md-4 d-none d-md-block">
            <ul class="footer-links list-unstyled">
              <li><a href="#">{{ __('footer.press') }}</a></li>
              <li><a href="#">{{ __('footer.customer_service') }}</a></li>
              <li><a href="#">{{ __('footer.giveaways') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-legal py-4">
    <div class="container">
      <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3">
        <div class="legal-left">
          <div class="small text-muted mb-2">{{ __('footer.part_of_hearst') }}</div>
          <div class="small text-muted mb-1">{{ __('footer.disclosure') }}</div>
          <div class="small text-muted">©{{ date('Y') }} DMDI Magazine. {{ __('footer.rights') }}</div>
        </div>

        <div class="legal-right">
          <nav class="legal-links">
            <a href="#">{{ __('footer.privacy') }}</a>
            <a href="#" class="ms-3">{{ __('footer.ca_notice') }}</a>
            <a href="#" class="ms-3">{{ __('footer.your_ca_rights') }}</a>
            <a href="#" class="ms-3">{{ __('footer.daa') }}</a>
            <a href="#" class="ms-3">{{ __('footer.terms') }}</a>
            <a href="#" class="ms-3">{{ __('footer.sitemap') }}</a>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="cookie-row py-4 d-flex justify-content-start">
      <button id="cookieChoicesBtn" class="btn cookie-btn">{{ __('footer.cookie_choices') }}</button>
    </div>
  </div>
</footer>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('cookieChoicesBtn');
    if (!btn) return;
    btn.addEventListener('click', function () {
      alert('{{ app()->getLocale() == "id" ? "Pengaturan cookie (placeholder)" : "Cookie settings (placeholder)" }}');
    });
  });
</script>