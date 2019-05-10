@if(Auth::user()->role_id == 1)
<li class="nav-item @if(!$selectedMenu)active @endif">
    <a class="nav-link" href="{{route('admin')}}">{{__('admin.menuTitle0')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'users')active @endif">
    <a class="nav-link" href="{{route('admin.users')}}">{{__('admin.menuTitle1')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'floors')active @endif">
    <a class="nav-link" href="{{route('admin.floors')}}">{{__('admin.menuTitle2')}}</a>
</li>
@endif
<li class="nav-item @if($selectedMenu == 'rooms')active @endif">
    <a class="nav-link" href="{{route('admin.rooms')}}">{{__('admin.menuTitle3')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'promotions')active @endif">
    <a class="nav-link" href="{{route('admin.promotions')}}">{{__('admin.menuTitle4')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'profile')active @endif">
    <a class="nav-link" href="{{route('profile')}}">{{__('admin.profile')}}</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{route('logout')}}">{{__('admin.logout')}}</a>
</li>