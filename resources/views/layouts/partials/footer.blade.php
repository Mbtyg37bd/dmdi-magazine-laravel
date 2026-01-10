<footer class="site-footer mt-8">
  <div class="container footer-top py-6">
    <div class="row align-items-start">
      <!-- Left Column:  Logo & Social Media -->
      <div class="col-12 col-lg-3 mb-4 mb-lg-0">
        <!-- Brand Logo -->
        <div class="footer-brand mb-3">
          <a href="{{ url('/' . (app()->getLocale() ?? 'id')) }}" class="d-inline-block logo-wrap" aria-label="DMDI home">
            <img src="{{ asset('images/dmdi-logo. png') }}" alt="DMDI" class="footer-logo"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';" />
            <span class="logo-text" style="display: none; font-weight:700; letter-spacing:0.08em;">DMDI</span>
          </a>
        </div>

        <!-- Social Media Icons - Dynamic from Database -->
        @php
            $socialLinks = \App\Models\SocialLink:: active()
                                                ->whereNotNull('url')
                                                ->where('url', '!=', '')
                                                ->ordered()
                                                ->get();
        @endphp

        @if($socialLinks->count() > 0)
        <div class="footer-social mb-3 d-flex gap-2" aria-label="Social links">
            @foreach($socialLinks as $social)
                <a href="{{ $social->url }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="social-link" 
                   aria-label="{{ $social->name }}"
                   style="display:  inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px;">
                    <img src="{{ asset('images/' . $social->icon) }}" 
                         alt="{{ $social->name }}" 
                         class="social-icon-img"
                         style="width: 20px; height: 20px;"
                         onerror="this.style.display='none';" />
                </a>
            @endforeach
        </div>
        @endif
      </div>

 <!-- Right Columns:   Footer Links - DYNAMIC FROM DATABASE -->
<div class="col-12 col-md-12 col-lg-9">
  @php
    // Get pages that should appear in footer
    $footerPages = \App\Models\Page::active()
                                   ->inFooter()
                                   ->orderBy('footer_order', 'asc')
                                   ->orderBy('title_' . app()->getLocale(), 'asc')
                                   ->get();
    
    // Group pages into columns (max 4 columns, ~3 items per column)
    $itemsPerColumn = 3;
    $totalColumns = 4;
    $pagesChunked = $footerPages->chunk($itemsPerColumn);
  @endphp

  @if($footerPages->count() > 0)
  <div class="row">
    @foreach($pagesChunked as $columnIndex => $pagesInColumn)
      @if($columnIndex < $totalColumns)
      <div class="col-6 col-md-3 mb-3">
        <ul class="footer-links list-unstyled">
          @foreach($pagesInColumn as $page)
            <li>
              <a href="{{ route('frontend.page.show', ['locale' => app()->getLocale(), 'slug' => $page->slug]) }}">
                {{ $page->getTitle() }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
      @endif
    @endforeach
  </div>
  @else
  <!-- Fallback jika belum ada pages -->
  <div class="row">
    <div class="col-12">
      <p class="text-muted small">Belum ada halaman di footer. </p>
    </div>
  </div>
  @endif
</div>

  <!-- Legal Section -->
  <div class="footer-legal py-4 border-top">
    <div class="container">
      <div class="row">
        <!-- Left:  Copyright -->
        <div class="col-12 col-md-6 mb-3 mb-md-0">
          <div class="small text-muted mb-2">{{ __('footer.part_of_hearst') }}</div>
          <div class="small text-muted mb-1">{{ __('footer.disclosure') }}</div>
          <div class="small text-muted">©{{ date('Y') }} DMDI Magazine.  {{ __('footer.rights') }}</div>
        </div>

        <!-- Right: Legal Links -->
        <div class="col-12 col-md-6">
          <nav class="legal-links d-flex flex-wrap gap-3 justify-content-md-end">
            <a href="#" class="small text-muted">{{ __('footer.privacy') }}</a>
            <a href="#" class="small text-muted">{{ __('footer.ca_notice') }}</a>
            <a href="#" class="small text-muted">{{ __('footer. your_ca_rights') }}</a>
            <a href="#" class="small text-muted">{{ __('footer. daa') }}</a>
            <a href="#" class="small text-muted">{{ __('footer.terms') }}</a>
            <a href="#" class="small text-muted">{{ __('footer.sitemap') }}</a>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Cookie Consent -->
  <div class="container py-3">
    <div class="d-flex justify-content-start">
      <button id="cookieChoicesBtn" class="btn btn-sm btn-outline-secondary cookie-btn">
        {{ __('footer. cookie_choices') }}
      </button>
    </div>
  </div>
</footer>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('cookieChoicesBtn');
    if (! btn) return;
    btn.addEventListener('click', function () {
      alert('{{ app()->getLocale() == "id" ? "Pengaturan cookie (placeholder)" : "Cookie settings (placeholder)" }}');
    });
  });
</script>