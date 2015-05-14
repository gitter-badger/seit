<section class="sidebar">
    {{--
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="img/avatar3.png" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
            <p>Hello, Jane</p>

            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    --}}
    {{--
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..."/>
            <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    --}}
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li>
            <a href="/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="treeview @if(Request::is('ram/*')) active @endif">
            <a href="#">
                <i class="fa fa-bar-chart-o"></i>
                <span>Research &amp; Manufacture</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              @if(Request::url() === URL::action('IndustryController@getBlueprints'))
                <li class="active">
              @else
                <li>
              @endif
                    <a href="{{ URL::action('IndustryController@getBlueprints') }}"><i class="fa fa-th-large"></i> <span>Blueprints</span></a>
                </li>
              @if(Request::url() === URL::action('IndustryController@getInvention'))
                <li class="active">
              @else
                <li>
              @endif
                    <a href="{{ URL::action('IndustryController@getInvention') }}"><i class="fa fa-th-large"></i> <span>Invention Chance</span></a>
                </li>
              @if(Request::url() === URL::action('IndustryController@getManufacture'))
                <li class="active">
              @else
                <li>
              @endif
                    <a href="{{ URL::action('IndustryController@getManufacture') }}"><i class="fa fa-th-large"></i> <span>Manufacture</span></a>
                </li>
              @if(Request::url() === URL::action('IndustryController@getCalculation'))
                <li class="active">
              @else
                <li>
              @endif
                    <a href="{{ URL::action('IndustryController@getCalculation') }}"><i class="fa fa-th-large"></i> <span>ME / TE Calculation</span></a>
                </li>
            </ul>
        </li>
        <li class="treeview @if(Request::is('crest/*')) active @endif">
            <a href="#">
                <i class="fa fa-bar-chart-o"></i>
                <span>Crest Data</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ URL::action('CrestDataController@getIndustryFacilityData') }}"><i class="fa fa-th-large"></i> <span>Industry Facilities</span></a></li>
                <li><a href="{{ URL::action('CrestDataController@getIndustryRegionalIndexes') }}"><i class="fa fa-th-large"></i> <span>Industry Indexes</span></a></li>
                <li><a href="{{ URL::action('CrestDataController@getMarketPriceIndex') }}"><i class="fa fa-th-large"></i> <span>Market Price Index</span></a></li>
            </ul>
        </li>
        <li class="@if(Request::is('profile')) active @endif"><a href="{{ URL::action('ProfileController@getIndex') }}"><i class="fa fa-user"></i> <span>Profile</span></a></li>
    </ul>
</section>
