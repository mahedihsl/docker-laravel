<li>
  <a href="{{route('devices')}}">
    <i class="fa fa-microchip"></i> <span>Manage Devices</span>
  </a>
</li>
<li>
  <a href="/performance">
    <i class="fa fa-tachometer"></i> <span>Performance</span>
  </a>
</li>
<li>
  <a href="/geofence/library">
    <i class="fa fa-map-signs"></i> <span>Geofence Library</span>
  </a>
</li>
<li>
  <a href="/billing">
    <i class="fa fa-money"></i> <span>Billing</span>
  </a>
</li>
<li>
  <a href="/customers">
    <i class="fa fa-address-card-o"></i> <span>Customers</span>
  </a>
</li>
<li>
  <a href="/vehicles">
    <i class="fa fa-car"></i> <span>Vehicles</span>
  </a>
</li>
<li>
  <a href="/users">
    <i class="fa fa-group"></i> <span>Users</span>
  </a>
</li>
<li>
  <a href="/service-monitor">
    <i class="fa fa-tachometer"></i> <span>Monitor Services (R&amp;D)</span>
  </a>
</li>
<li>
  <a href="/activation/report">
    <i class="fa fa-key"></i> <span>Activation Report</span>
  </a>
</li>
<li>
  <a href="/bill/entry">
    <i class="fa fa-key"></i> <span>Bill Entry</span>
  </a>
</li>
<li>
  <a href="/billing/report">
    <i class="fa fa-key"></i> <span>Billing Report</span>
  </a>
</li>
<li>
  <a href="/billing/drilldown">
    <i class="fa fa-key"></i> <span>Billing Drilldown</span>
  </a>
</li>
<li>
  <a href="/engagement/report">
    <i class="fa fa-key"></i> <span>Customer Engagement</span>
  </a>
</li>
<li>
  <a href="/unhealthy/device">
    <i class="fa fa-medkit"></i> <span>Unhealthy Device</span>
  </a>
</li>
<li>
  <a href="/due/notice">
    <i class="fa fa-bell"></i> <span>Due Bill Notice</span>
  </a>
</li>
<li>
  <a href="/bus/routes">
    <i class="fa fa-road" aria-hidden="true"></i> <span>Bus Routes</span>
  </a>
</li>
<li>
  <a href="/complains">
    <i class="fa fa-archive" aria-hidden="true"></i> <span>Complains</span>
  </a>
</li>
<li>
  <a href="/lastpulse">
    <i class="fa fa-tachometer"></i> <span>Last pulse</span>
  </a>
</li>
<li>
  <a href="/promotion">
    <i class="fa fa-tags" aria-hidden="true"></i> <span>Promo Schemes</span>
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
