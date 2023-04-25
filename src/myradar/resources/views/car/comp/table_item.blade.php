<tr>
  <td class="text-center">{{ $serial }}</td>
  <td>
    <div class="row row-eq-height">
      <div class="col-xs-3">
        <a href="/manage/customer/{{$car->user_id}}">
          <img src="img/user_avatar.png" alt="" class="img img-circle user-thumb"/>
        </a>
      </div>
      <div class="col-xs-9">
        <a href="/manage/customer/{{$car->user_id}}">
          <strong class="user-name">{{ $car->user->name }}</strong>
        </a>
        <br>
        <span class="user-phone">
          <i class="fa fa-phone"></i> {{ $car->user->phone }}
        </span>
      </div>
    </div>
  </td>
  <td class="text-center">
    <a href="/car/details/{{$car->id}}">{{ $car->reg_no }}</a>
  </td>
  <td class="text-center">
    @php
      $payment = $car->getLastPayment();
    @endphp
    @if ( ! is_null($payment))
      {{ $payment->paid_on->toDateString() }}<br>
      {{ $payment->getValidity() }}
    @endif
  </td>
  <td class="text-center">
    <strong class="{{$car->user->isEnabled() ? 'text-success' : 'text-danger'}}">
      <i class="fa fa-circle-o"></i>
      {{$car->user->isEnabled() ? 'ENABLED' : 'DISABLED'}}
    </strong>
  </td>
</tr>
