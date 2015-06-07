@extends('layouts.masterLayout')

@section('html_title', 'Research & Manufacture Jobs')
@section('page_content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header ">
        <h3 class="box-title">Active Jobs</h3>
        <div class="box-tools">&nbsp;</div>
      </div>
      <div class="box-body">
        <table class="table table-condensed table-hover" id="">
            <thead>
                <tr>
                    <th>Start</th>
                    <th>End</th>
                    <th>Type</th>
                    <th>State</th>
                    <th>Installed by</th>
                    <th>Product</th>
                    <th>Station Name</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Start</th>
                    <th>End</th>
                    <th>Type</th>
                    <th>State</th>
                    <th>Installed by</th>
                    <th>Product</th>
                    <th>Station Name</th>
                </tr>
            </tfoot>
            <tbody>
              @foreach($payload['jobs'] as $job)
                <tr>
                  <td><span data-sort="{!! $job->startDate !!}">{!! \Carbon\Carbon::parse($job->startDate)->diffForHumans() !!}</span></td>
                  <td><span data-sort="{!! $job->endDate !!}">{!! \Carbon\Carbon::parse($job->endDate)->diffForHumans() !!}</span></td>
                {{-- Activity --}}
                @if($job->activityID == 1)
                  <td><span class="label bg-red">Manufacture</span></td>
                @elseif($job->activityID == 3)
                  <td><span class="label bg-red">TE</span></td>
                @elseif($job->activityID == 4)
                  <td><span class="label bg-red">ME</span></td>
                @elseif($job->activityID == 5)
                  <td><span class="label bg-red">Copy</span></td>
                @elseif($job->activityID == 7)
                  <td><span class="label bg-red">Reverse</span></td>
                @elseif($job->activityID == 8)
                  <td><span class="label bg-red">Invention</span></td>
                @endif()
                {{-- Status --}}
                @if($job->status == 1)
                  <td><span class="label bg-yellow">Active</span></td>
                @elseif($job->status == 2)
                  <td><span class="label bg-green">Paused</span></td>
                @elseif($job->status == 3)
                  <td><span class="label bg-green">Ready</span></td>
                @endif
                  <td><img src="{!! \SeIT\Services\Helper::getImageByID($job->installerID, 32) !!}" class="img-circle" width="20px" height="20px"/> {{ $job->installerName }}</td>
                  {{--<td><img src="{!! \SeIT\Services\Helper::getImageByID($job->blueprintTypeID, 32) !!}" class="img-circle" width="20px" height="20px"/> {{ $job->blueprintTypeName }}</td>--}}
                  <td><img src="{!! \SeIT\Services\Helper::getImageByID($job->productTypeID, 32) !!}" class="img-circle" width="20px" height="20px"/> {{ $job->productTypeName }}</td>
                  <td>{{ $job->stationName }}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </div>
</div>
@stop

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $('#extended-dt').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
</script>
@stop
