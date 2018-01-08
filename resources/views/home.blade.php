@extends('layouts.app')

@section('content')
<script src="https://use.fontawesome.com/d42e713b06.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="loggedin">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>

            <div class="panel panel-default" id="homePanel">
                <div class="panel-heading">Home</div>

                <div class="panel-body text-center">
                    <h1>Welcome to the roman numerals converter!</h1>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col-sm-4">
                        <button type="button" class="btn btn-lg btn-primary" id="btnConverter">Converter</button>
                      </div>
                      <div class="col-sm-4">
                        <button type="button" class="btn btn-lg btn-success" id="btnStatistics">Statistics</button>
                      </div>
                      <div class="col-sm-4">
                        <button type="button" class="btn btn-lg btn-danger">Coming Soon</button>
                      </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default  display-none" id="converterPanel">
                <div class="panel-heading">Converter</div>

                <div class="panel-body text-center">
                  <h1>Roman Numerals Converter</h1>
                  <div class="Row text-center">
                    <div class="col-sm-offset-3 col-sm-6">
                      <label for="number">What number would you like to convert?</label>
                      <input type="number" class="form-control" id="txtNumber">
                      <br>
                      <div class="row">
                        <div class="col-sm-6">
                          <h3>Original Number:</h3>
                          <h4 id="base10Results" class="overflow-break odometer"></h4>
                        </div>
                        <div class="col-sm-6">
                          <h3>Roman Numeral:</h3>
                          <h4 id="romanNumeralResults" class="overflow-break" data-in-effect="fadeInUp" data-out-effect="fadeOutUp"></h4>
                        </div>
                      </div>
                      <div>
                        <h5 id="converterErrors" class="warning"></h5>
                      </div>
                    </div>
                  </div>

                  <div class="Row">
                    <div class="col-sm-offset-10 col-sm-2">
                      <button type="button" class="btn btn-sm btn-warning" id="btnConvertBack">Back</button>
                    </div>
                  </div>

                </div>
            </div>

            <div class="panel panel-default  display-none" id="statisticPanel">
                <div class="panel-heading">Statistics</div>

                <div class="panel-body text-center">
                  <h1>Statistics</h1>
                  <div class="Row">
                    <div class="col-sm-offset-10 col-sm-2">
                      <button type="button" class="btn btn-sm btn-warning" id="btnStatsBack">Back</button>
                    </div>
                  </div>

                </div>
            </div>


        </div>
    </div>
</div>

<link rel="stylesheet" href="css/odometer-theme-default.css" />

<script src="js/odometer.js"></script>


<script>
$(document).ready(function(){
  $('#loggedin').delay(2000).slideUp(1000);

  $('#btnConverter').click(function() {
    $('#homePanel').delay(500).slideUp(500);
    $('#converterPanel').delay(1500).slideDown(500);
  });

  $('#btnStatistics').click(function() {
    $('#homePanel').delay(500).slideUp(500);
    $('#statisticPanel').delay(1500).slideDown(500);
  });

  $('#btnStatsBack').click(function() {
    $('#statisticPanel').delay(500).slideUp(500);
    $('#homePanel').delay(1500).slideDown(500);
  });

  $('#btnConvertBack').click(function() {
    $('#converterPanel').delay(500).slideUp(500);
    $('#homePanel').delay(1500).slideDown(500);
  });

  $('#txtNumber').change(function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var numberVal = $('#txtNumber').val();
    console.log((numberVal.length));
    if ((numberVal).length != 0) {
      if(numberVal < 5000) {
        $('#converterErrors').html('');
        $.ajax({
          type: 'post',
          url: '{{ route("convertNumeral") }}',
          data: {_token: CSRF_TOKEN,'numberVal':numberVal},
          success:function(data){
            console.log(data);
            $('#base10Results').html(numberVal);
            $('#romanNumeralResults').text(data);
          },
          error:function(data){
            console.log(data);
          },
        });//end ajax
      } else {
        $('#converterErrors').html('<i class="fa fa-lg fa-exclamation-triangle"></i> You need to enter a value bellow 5000!');

      };

    };
  });

});

</script>
@endsection
