@extends('layouts.masterLayout')

@section('html_title', 'Dashboard')

@section('page_content')

<div class="row">
  <div class="col-md-2">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{!! $payload['count_queued'] !!}</h3>
        <p>Queued Jobs</p>
      </div>
    </div>
  </div><!-- ./col-md-2 -->
  <div class="col-md-2">
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{!! $payload['count_done'] !!}</h3>
        <p>Done Jobs</p>
      </div>
    </div>
  </div><!-- ./col-md-2 -->
  <div class="col-md-2">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{!! $payload['count_working'] !!}</h3>
        <p>Working Jobs</p>
      </div>
    </div>
  </div><!-- ./col-md-2 -->
  <div class="col-md-2">
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{!! $payload['count_error'] !!}</h3>
        <p>Error Jobs</p>
      </div>
    </div>
  </div><!-- ./col-md-2 -->
  <div class="col-md-2">
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{!! $payload['count_failed'] !!}</h3>
        <p>Failed Jobs</p>
      </div>
    </div>
  </div><!-- ./col-md-2 -->
  <div class="col-md-2">
    <div class="small-box bg-navy">
      <div class="inner">
        <h3>{{ $payload['entities_unknown'] }}</h3>
        <p>Unresolved Entities</p>
      </div>
    </div>
  </div><!-- ./col-md-2 -->
</div><!-- ./row -->

<div class="row">
  <div class="col-md-4">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Industry Facilities</h3>
        <div class="box-tools pull-right">
            <a href='{!! URL::action('DashboardController@getRefreshIndustryFacilities') !!}' class="btn btn-box-tool"><i class="fa fa-refresh"></i></a>
        </div>
      </div><!-- ./box-header -->
      <div class="box-body">
        <table class="table table-condensed">
          <tr>
            <td>Entry Count:</td>
            <td>{{ $payload['crestIndustryFacilities']->count }}</td>
          </tr>
          <tr>
            <td>Newest Entry:</td>
            <td>{{ \Carbon\Carbon::parse($payload['crestIndustryFacilities']->max)->format('H:i:s d.m.Y') }}</td>
          </tr>
          <tr>
            <td>Oldest Entry:</td>
            <td>{{ \Carbon\Carbon::parse($payload['crestIndustryFacilities']->min)->format('H:i:s d.m.Y') }}</td>
          </tr>
        </table>
      </div><!-- ./box-body -->
    </div><!-- ./box -->
  </div><!-- ./col-md-4 -->
  <div class="col-md-4">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Industry Systems</h3>
        <div class="box-tools pull-right">
            <a href='{!! URL::action('DashboardController@getRefreshIndustrySystems') !!}' class="btn btn-box-tool"><i class="fa fa-refresh"></i></a>
        </div>
      </div><!-- ./box-header -->
      <div class="box-body">
        <table class="table table-condensed">
          <tr>
            <td>Entry Count:</td>
            <td>{{ $payload['crestIndustrySystems']->count }}</td>
          </tr>
          <tr>
            <td>Newest Entry:</td>
            <td>{{ \Carbon\Carbon::parse($payload['crestIndustrySystems']->max)->format('H:i:s d.m.Y') }}</td>
          </tr>
          <tr>
            <td>Oldest Entry:</td>
            <td>{{ \Carbon\Carbon::parse($payload['crestIndustrySystems']->min)->format('H:i:s d.m.Y') }}</td>
          </tr>
        </table>
      </div><!-- ./box-body -->
    </div><!-- ./box -->
  </div><!-- ./col-md-4 -->
  <div class="col-md-4">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Market Prices</h3>
        <div class="box-tools pull-right">
            <a href='{!! URL::action('DashboardController@getRefreshMarketPrices') !!}' class="btn btn-box-tool"><i class="fa fa-refresh"></i></a>
        </div>
      </div><!-- ./box-header -->
      <div class="box-body">
        <table class="table table-condensed">
          <tr>
            <td>Entry Count:</td>
            <td>{{ $payload['crestMarketPrices']->count }}</td>
          </tr>
          <tr>
            <td>Newest Entry:</td>
            <td>{{ \Carbon\Carbon::parse($payload['crestMarketPrices']->max)->format('H:i:s d.m.Y') }}</td>
          </tr>
          <tr>
            <td>Oldest Entry:</td>
            <td>{{ \Carbon\Carbon::parse($payload['crestMarketPrices']->min)->format('H:i:s d.m.Y') }}</td>
          </tr>
        </table>
      </div><!-- ./box-body -->
    </div><!-- ./box -->
  </div><!-- ./col-md-4 -->
</div><!-- ./row -->

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Queue Details</h3>
            </div><!-- ./box-header -->
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#done" data-toggle="tab">Done ({!! count($payload['done']) !!})</a></li>
                        <li><a href="#error" data-toggle="tab">Error ({!! count($payload['error']) !!})</a></li>
                        <li><a href="#queued" data-toggle="tab">Queued ({!! count($payload['queued']) !!})</a></li>
                        <li><a href="#working" data-toggle="tab">Working ({!! count($payload['working']) !!})</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="done">
                        @if (count ($payload['done']) > 0)
                          
                          <table class="table">
                            <thead>
                              <th>Owner</th>
                              <th>Command</th>
                              <th>Last Update</th>
                            </thead>
                          @foreach($payload['done'] as $entry)
                            <tr>
                              @if($entry->keyID == -1)<td>CREST</td>@else<td>{!! ($entry->keyID) !!}</td>@endif
                              <td>{!! \SeIT\Services\Helper::stripNamespaceFromClassname($entry->command) !!}</td>
                              <td>{!! \Carbon\Carbon::parse($entry->updated_at)->format('H:i:s d.m.Y') !!}</td>
                            </tr>
                          @endforeach()
                          </table>
                        @else
                          <b>No Entries found.</b>
                        @endif()
                      </div><!-- ./tab-pane -->
                      <div class="tab-pane" id="error">
                        @if (count ($payload['error']) > 0)
                          
                          <table class="table">
                            <thead>
                              <th>Owner</th>
                              <th>Command</th>
                              <th>Last Update</th>
                            </thead>
                          @foreach($payload['error'] as $entry)
                            <tr>
                              @if($entry->keyID == -1)<td>CREST</td>@else<td>{!! ($entry->keyID) !!}</td>@endif
                              <td><a href="#{{ $entry->jobID }}">{!! \SeIT\Services\Helper::stripNamespaceFromClassname($entry->command) !!}</a></td>
                              <td>{!! \Carbon\Carbon::parse($entry->updated_at)->format('H:i:s d.m.Y') !!}</td>
                            </tr>
                          @endforeach()
                          </table>
                        @else
                          <b>No Entries found.</b>
                        @endif()
                      </div><!-- ./tab-pane -->
                      <div class="tab-pane" id="queued">
                        @if (count ($payload['queued']) > 0)
                          
                          <table class="table">
                            <thead>
                              <th>Owner</th>
                              <th>Command</th>
                              <th>Last Update</th>
                            </thead>
                          @foreach($payload['queued'] as $entry)
                            <tr>
                              @if($entry->keyID == -1)<td>CREST</td>@else<td>{!! ($entry->keyID) !!}</td>@endif
                              <td>{!! \SeIT\Services\Helper::stripNamespaceFromClassname($entry->command) !!}</td>
                              <td>{!! \Carbon\Carbon::parse($entry->updated_at)->format('H:i:s d.m.Y') !!}</td>
                            </tr>
                          @endforeach()
                          </table>
                        @else
                          <b>No Entries found.</b>
                        @endif()
                      </div><!-- ./tab-pane -->
                      <div class="tab-pane" id="working">
                        @if (count ($payload['working']) > 0)
                          
                          <table class="table">
                            <thead>
                              <th>Owner</th>
                              <th>Command</th>
                              <th>Last Update</th>
                            </thead>
                          @foreach($payload['working'] as $entry)
                            <tr>
                              @if($entry->keyID == -1)<td>CREST</td>@else<td>{!! ($entry->keyID) !!}</td>@endif
                              <td>{!! \SeIT\Services\Helper::stripNamespaceFromClassname($entry->command) !!}</td>
                              <td>{!! \Carbon\Carbon::parse($entry->updated_at)->format('H:i:s d.m.Y') !!}</td>
                            </tr>
                          @endforeach()
                          </table>
                        @else
                          <b>No Entries found.</b>
                        @endif()
                      </div><!-- ./tab-pane -->
                    </div><!-- ./tab-content -->
                </div><!-- ./nav-tabs-custom -->
            </div><!-- ./box-body -->
        </div><!-- ./box -->
    </div><!-- col-md-6 -->
</div><!-- ./row -->

@stop

@section('javascript')

@stop
