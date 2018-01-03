@extends('layouts.app')

@section('content')
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
                  <div class="Row">
                    <div class="col-sm-10">
                    </div>
                    <div class="col-sm-2">
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
                    <div class="col-sm-10">
                    </div>
                    <div class="col-sm-2">
                      <button type="button" class="btn btn-sm btn-warning" id="btnStatsBack">Back</button>
                    </div>
                  </div>

                </div>
            </div>


        </div>
    </div>
</div>

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
});

</script>
@endsection
