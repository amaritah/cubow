@extends('admin.admin-layout', ['selectedMenu' => false])

@section('contentTitle')
<h1>Dashboard</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-8 col-sm-12 col-xs-12 col-lg-8 col-md-8 row">
        <div class="col-4 score-container">
            <div>
                <i class="far fa-frown-open fa-3x"></i>
                <span class="counter">{{count($scores1)}}</span>
            </div>
        </div>

        <div class="col-4 score-container">
            <div>
                <i class="far fa-meh fa-3x"></i>
                <span class="counter">{{count($scores2)}}</span>
            </div>
        </div>
        
        <div class="col-4 score-container">
            <div>
                <i class="far fa-smile fa-3x"></i>
                <span class="counter">{{count($scores3)}}</span>
            </div>
        </div>
        
        </div>
    <div class="col-xl-4 col-sm-12 col-xs-12 col-lg-4 col-md-4 row">
        
        <div class="col-12 dashboard-container red">
            <div>
                <i class="fas fa-building fa-2x"></i>
                <span class="counter">{{count($floors)}}</span>{{__('admin.floors')}}
            </div>
        </div>
        <div class="col-12 dashboard-container yellow">
            <div>
                <i class="fas fa-users fa-2x "></i>
                <span class="counter">{{count($users)}}</span>{{__('admin.users')}}
            </div>
        </div>
        <div class="col-12 dashboard-container green">
            <div>
                <i class="fas fa-store fa-2x"></i>
                <span class="counter">{{count($rooms)}}</span>{{__('admin.rooms')}}
            </div>
        </div>
        <div class="col-12 dashboard-container blue">
            <div>
                <i class="fas fa-certificate fa-2x"></i>
                <span class="counter">{{count($promotions)}}</span>{{__('admin.promotions')}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="{{ URL::asset('js/waypoints.min.js') }}"></script>
<script src="{{ URL::asset('js/counterup.min.js') }}"></script>
<script>
    $(function(){
        $('.counter').counterUp({
            delay: 100,
            time: 2000
        });
    });
</script>
@endsection