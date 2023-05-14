<style media="screen">
<style media="screen">
.sidebar-menu {
    margin: 0;
    width: 100%;
}
.sidebar-menu > li {
    padding: 2px 2px;
    border-left: 2px solid rgb(240, 240, 240);
    list-style: none;
}

.sidebar-menu > li > span {
    color: #757575;
    font-weight: bold;
}
.sidebar-menu > li:hover, .sidebar-menu > li > a.active {
    background: rgb(255, 255, 255);
    border-left: 6px solid rgb(84, 72, 236);
    transition: all .3s ease-out;
}
.sidebar-menu > li:hover > a > span, .sidebar-menu > li.active > a > span {
    color: rgb(84, 72, 236);
}
.fa-cab{
  color: #283593;
}
.fa-map-marker{
  color:#AD1457;
}
.fa-align-justify{
  color: #1565C0;
}
.fa-line-chart{
  color:#FF8F00;
}
.fa-tachometer{
  color:#AD1457;
}
.fa-area-chart{
  color: #00695C;
}
.fa-users{
  color: #00695C;
}
.fa-address-book{
  color: #37474F;
}
.fa-cog{
  color: #3F51B5;
}
</style>
@if ($user->customer_type == 1)
  <li>
    <a href="{{route('car-tracking')}}">
      <i class="fa fa-cab"></i> <span>Vehicle Tracking</span>
    </a>
  </li>
  <li>
    <a href="{{route('area-fence', ['user_id' => $user->id])}}">
      <i class="fa fa-map"></i> <span>Area Geofence</span>
    </a>
  </li>
  <li>
    <a href="{{route('service-view')}}">
      <i class="fa fa-line-chart"></i> <span>Service View</span>
    </a>
  </li>
  <li>
    <a href="{{route('refuel-feed')}}">
      <i class="fa fa-tachometer"></i> <span>Fixing Fuel Meter</span>
    </a>
  </li>
  <li>
  <a href="{{ route('url-amount', ['uId' => $user->uid])}}">
    <i class="fa fa-money"></i> <span>Pay Due Bill</span>
  </a>
</li>
@elseif ($user->customer_type == 2)
  <li>
    <a href="{{route('map-search')}}">
      <i class="fa fa-map-marker"></i> <span>Map Search</span>
    </a>
  </li>
  <li>
    <a href="{{route('car-tracking')}}">
      <i class="fa fa-cab"></i> <span>Vehicle Tracking</span>
    </a>
  </li>
  <li>
    <a href="{{route('area-fence', ['user_id' => $user->id])}}">
      <i class="fa fa-map"></i> <span>Area Geofence</span>
    </a>
  </li>
  <li>
    <a href="{{route('text-tracker')}}">
      <i class="fa fa-align-justify"></i> <span>Text Tracker</span>
    </a>
  </li>
  <li>
    <a href="{{route('service-view')}}">
      <i class="fa fa-line-chart"></i> <span>Service View</span>
    </a>
  </li>
  <li>
    <a href="{{route('driving-hour')}}">
      <i class="fa fa-bar-chart"></i> <span>Driving Hour</span>
    </a>
  </li>
  <li>
    <a href="{{route('duty-hour')}}">
      <i class="fa fa-line-chart"></i> <span>Duty Hour</span>
    </a>
  </li>
  <li>
    <a href="{{route('mileage-report')}}">
      <i class="fa fa-tachometer"></i> <span>Mileage Report</span>
    </a>
  </li>
  <li>
    <a href="{{route('tail-report')}}">
      <i class="fa fa-area-chart"></i> <span>Tail Report</span>
    </a>
  </li>
  <li>
    <a href="{{route('generators')}}">
      <i class="fa fa-flash"></i> <span>Generators</span>
    </a>
  </li>
  <li>
    <a href="{{route('drivers')}}">
      <i class="fa fa-users"></i> <span>Manage Drivers</span>
    </a>
  </li>
  <li>
    <a href="{{route('employees')}}">
      <i class="fa fa-address-book"></i> <span>Manage Employees</span>
    </a>
  </li>
  <li>
    <a href="{{route('enterprise-settings')}}">
      <i class="fa fa-cog"></i> <span>Settings</span>
    </a>
  </li>
  <li>
  <a href="{{ route('url-amount', ['uId' => $user->uid])}}">
    <i class="fa fa-money"></i> <span>Pay Due Bill</span>
  </a>
</li>

@endif
