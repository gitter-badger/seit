  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Add Key</h3>
      </div><!-- ./box-header -->
      <div class="box-body">
        {!! \Form::open(array('method' => 'post', 'action' => 'ProfileController@postAddKey' , 'class' => 'form-group', 'id' => 'key-form')) !!}
        <fieldset>
          
          <div class="form-group">
            <div class="col-md-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                {!! \Form::text('keyID', null, array('autocomplete' => 'off', 'id' => 'keyID', 'class' => 'form-control select2-input', 'placeholder' => 'keyID')) !!}
              </div>
            </div>
          </div>
          
        </fieldset>
        <fieldset>
          <div class="form-group">            
            <div class="col-md-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-magic"></i></span>
                {!! \Form::text('vCode', null, array('autocomplete' => 'off', 'id' => 'vCode', 'class' => 'form-control select2-input', 'placeholder' => 'vCode')) !!}
              </div>
            </div>
          </div>

        </fieldset>
        <fieldset>
          <div class="form-group">            
            <div class="col-md-12">
              <div class="input-group">
                {!! \Form::submit(null, array('id' => 'submit', 'class' => 'form-control select2-input')) !!}
              </div>
            </div>
          </div>
        
        </fieldset>
        {!! \Form::close() !!}
      </div><!-- ./box-body -->
      <!--<div class="box-footer">
      </div>-->
    </div><!-- ./box -->
  </div><!-- ./col-md-6 -->
