@extends('layouts.masterLayout')

@section('html_title', 'Profile')

@section('page_content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Profile Details</h3>
      </div><!-- ./box-header -->
      <div class="box-body">
        <table class="table">
          <tbody>
            <tr>
              <td>Name:</td>
              <td>{{ $user->name }}</td>
            </tr>
            <tr>
              <td>E-Mail:</td>
              <td>{{ $user->email }}</td>
            </tr>
            <tr>
              <td>Created:</td>
              <td>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
            </tr>
            <tr>
              <td>Updated:</td>
              <td>{{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}</td>
            </tr>
          </tbody>
        </table>
      </div><!-- ./box-body -->
      <!--<div class="box-footer">
      </div>-->
    </div><!-- ./box -->
  </div><!-- ./col-md-12 -->
</div>
<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Keys</h3>
      </div><!-- ./box-header -->
      <div class="box-body">
        @if(count($keys))
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>keyID</th>
                <th>Type</th>
                <th>Mask</th>
                <th>Expires</th>
                <th>Characters</th>
              </tr>
            </thead>
            <tbody>
              @foreach($keys as $key)
              <tr>
                <td>{!! $key->keyID !!}</td>
                <td>{!! $key->type !!}</td>
                <td>{!! $key->accessMask !!}</td>
                <td>
                    @if($key->expires == null)
                      Never
                    @else
                      {!! Carbon\Carbon::parse($key->expires) !!}
                    @endif
                </td>
                <td>
                    @foreach(SeIT\Services\BaseApi::findKeyCharactersFull($key->keyID) as $character)
                      <img src="{{ SeIT\Services\Helper::getImageByID($character['characterID'], 32) }}" class="img-circle" data-toggle="tooltip" title="{{ $character['characterName'] }}"/>
                    @endforeach
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p>No Keys found.</p>
        @endif
      </div><!-- ./box-body -->
      <!--<div class="box-footer">
      </div>-->
    </div><!-- ./box -->
  </div>
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">SSO Links</h3>
      </div><!-- ./box-header -->
      <div class="box-body">
        @if(count($ssolinks))
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Character</th>
                <th>Type</th>
                <th>*</th>
                <th>*</th>
                <th>*</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ssolinks as $ssolink)
              <tr>
                <td>{{ $ssolink->characterName }} <img src="//image.eveonline.com/Character/{!! $ssolink->characterID !!}_32.jpg" class="img-circle" data-toggle="tooltip" title="{!! $ssolink->characterName !!}"/></td>
                <td>{{ $ssolink->tokenType }}</td>
                <td>{{ $ssolink->scopes }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p>No SSO links found.</p>
        @endif
      </div><!-- ./box-body -->
      <!--<div class="box-footer">
      </div>-->
    </div><!-- ./box -->
  </div>
</div>

@stop

@section('javascript')

@stop
