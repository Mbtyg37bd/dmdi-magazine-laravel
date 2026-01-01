@extends('admin.layouts.admin')

@section('title','Ads')

@section('content')
<div class="card mb-3">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Ads</h5>
      <a href="{{ route('ads.create') }}" class="btn btn-primary">Create Ad</a>
    </div>

    <!-- Stats row -->
    <div class="row mb-4" id="ads-stats-cards">
      <div class="col-md-3">
        <div class="card border">
          <div class="card-body">
            <small class="text-muted">Today so far</small>
            <div class="h4 mt-2" id="stat-today">-</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border">
          <div class="card-body">
            <small class="text-muted">Yesterday</small>
            <div class="h4 mt-2" id="stat-yesterday">-</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border">
          <div class="card-body">
            <small class="text-muted">Last 7 days</small>
            <div class="h4 mt-2" id="stat-last7">-</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border">
          <div class="card-body">
            <small class="text-muted">This month</small>
            <div class="h4 mt-2" id="stat-month">-</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart -->
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
          <h6 class="mb-0">Click Report By Date</h6>
        </div>
        <canvas id="adsClicksChart" height="120"></canvas>
      </div>
    </div>

    <!-- existing ads table -->
    <div class="card">
      <div class="card-body p-0">
        @include('admin.ads._table', ['ads' => $ads])
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById('adsClicksChart').getContext('2d');
  let chart = null;

  function fetchStats() {
    fetch("{{ route('ads.stats') }}", {
      method: 'GET',
      credentials: 'same-origin',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    })
    .then(json => {
      // fill summary cards
      document.getElementById('stat-today').textContent = json.summary.today ?? 0;
      document.getElementById('stat-yesterday').textContent = json.summary.yesterday ?? 0;
      document.getElementById('stat-last7').textContent = json.summary.last7 ?? 0;
      document.getElementById('stat-month').textContent = json.summary.thisMonth ?? 0;

      // render chart
      const labels = (json.labels || []).map(l => {
        try { return (new Date(l)).toLocaleDateString(); } catch(e){ return l; }
      });
      const data = json.data || [];

      const dataset = {
        labels: labels,
        datasets: [{
          label: '# of Clicks',
          data: data,
          borderColor: '#6f42c1',
          backgroundColor: 'rgba(111,66,193,0.08)',
          tension: 0.35,
          pointRadius: 3,
          pointBackgroundColor: '#6f42c1',
          fill: true
        }]
      };

      if (chart) {
        chart.data = dataset;
        chart.update();
      } else {
        chart = new Chart(ctx, {
          type: 'line',
          data: dataset,
          options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { display: true }, y: { beginAtZero: true, ticks: { stepSize: 1 } } }
          }
        });
      }
    })
    .catch(err => {
      console.error('Failed to load ad stats', err);
      // optional: show message in UI
    });
  }

  fetchStats();
});
</script>
@endpush