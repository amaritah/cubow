<li class="nav-item @if(!$selectedMenu)active @endif">
    <a class="nav-link" data-container="dashboard" href="/">{{__('admin.menuTitle0')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'users')active @endif">
    <a class="nav-link" data-container="users" href="{{route('admin.users')}}">{{__('admin.menuTitle1')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'floors')active @endif">
    <a class="nav-link" data-container="floors" href="{{route('admin.floors')}}">{{__('admin.menuTitle2')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'rooms')active @endif">
    <a class="nav-link" data-container="rooms" href="{{route('admin.rooms')}}">{{__('admin.menuTitle3')}}</a>
</li>
<li class="nav-item @if($selectedMenu == 'promotions')active @endif">
    <a class="nav-link" data-container="promotions" href="{{route('admin.promotions')}}">{{__('admin.menuTitle4')}}</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{route('logout')}}">{{__('admin.logout')}}</a>
</li>