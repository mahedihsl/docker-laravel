@component('mail::message')

@component('mail::panel',['color'=>'red'])
{{$text}}
@endcomponent

Please Set new Password By Clicking the button
@component('mail::button', ['url' => $link])
Set New Password
@endcomponent

Thanks,<br>
HyperSystems
@endcomponent
