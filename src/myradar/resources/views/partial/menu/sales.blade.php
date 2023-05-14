<li>
  <a href="{{route('billing')}}">
    <i class="fa fa-cab"></i> <span>Billing</span>
    {{-- <span class="pull-right-container">
      <small class="label pull-right bg-green">Hot</small>
    </span> --}}
  </a>
</li>
<li>
  <a href="/bill/entry">
    <i class="fa fa-key"></i> <span>Bill Entry</span>
  </a>
</li>
<li>
  <a href="/customers">
    <i class="fa fa-line-chart"></i> <span>Customers</span>
    {{-- <span class="pull-right-container">
      <small class="label pull-right bg-green">Hot</small>
    </span> --}}
  </a>
</li>
<li>
  <a href="/leads">
    <i class="fa fa-bolt"></i> <span>Leads</span>
    {{-- <span class="pull-right-container">
      <small class="label pull-right bg-green">Hot</small>
    </span> --}}
  </a>
</li>
<li>
  <a href="/geofence/library">
    <i class="fa fa-map-signs"></i> <span>Geofence Library</span>
  </a>
</li>
<li>
  <a href="/performance">
    <i class="fa fa-tachometer"></i> <span>Performance</span>
  </a>
</li>
<li>
  <a href="/complains">
    <i class="fa fa-archive" aria-hidden="true"></i> <span>Complains</span>
  </a>
</li>
<li>
  <a href="/engagement/report">
    <i class="fa fa-key"></i> <span>Customer Engagement</span>
  </a>
</li>
<li>
  <a href="/messages">
    <i class="fa fa-envelope"></i> <span>Messages</span>
    @php
    $n = \App\Entities\Message::where('created_at', '>', \Carbon\Carbon::today())->count()
    @endphp
    @if ($n)
    <span class="pull-right-container">
      <small class="label pull-right bg-green">{{$n}}</small>
    </span>
    @endif
  </a>
</li>
@include('partial.menu.test')