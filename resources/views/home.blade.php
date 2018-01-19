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
                      <div class="col-sm-4" style="padding-bottom:2%;">
                        <button type="button" class="btn btn-lg btn-primary" id="btnConverter">Converter</button>
                      </div>
                      <div class="col-sm-4" style="padding-bottom:2%;">
                        <button type="button" class="btn btn-lg btn-success" id="btnStatistics">Statistics</button>
                      </div>
                      <div class="col-sm-4" style="padding-bottom:2%;">
                        <button type="button" class="btn btn-lg btn-danger" id="btnHistory">History</button>
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
                    <div class="col-sm-5">
                      <h3><strong>Most Conversions: </strong></h3>
                      <h4 id="mostConversions"></h4>

                    </div>

                    <div class="col-sm-offset-1 col-sm-5">
                      <h3><strong>Most Popular number: </strong></h3>
                      <h4 id="popNumber" class="odometer"></h4>
                      <p id="popNumberVal" class="display-none"></p>
                    </div>

                  </div>

                  <div class="Row">
                    <div class="col-sm-5">
                      <h3><strong>Total Conversions: </strong></h3>
                      <h4 id="totalConversions" class="odometer"></h4>
                      <p id="totalConversionsVal" class="display-none"></p>

                    </div>

                    <div class="col-sm-offset-1 col-sm-5">
                      <h3><strong>Total User Count:</strong></h3>
                      <h4 id="totalUsers" class="odometer"></h4>
                      <p id="totalUsersVal" class="display-none"></p>
                    </div>

                    <div class="col-sm-offset-10 col-sm-2">
                      <button type="button" class="btn btn-sm btn-warning" id="btnStatsBack">Back</button>
                    </div>
                  </div>

                </div>
            </div>

            <div class="panel panel-default  display-none" id="historyPanel">
                <div class="panel-heading">History</div>

                <div class="panel-body text-center">
                  <h1>Recent Conversion History</h1>
                    <table id="historyTable" class="table table-bordered table-hover table-responsive">
                      <thead>
                        <tr>
                          <th>UserName</th>
                          <th>Original Number</th>
                          <th>Roman Numeral</th>
                          <th>Timestamp</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>

                    <div>
                      <button type="button" class="btn btn-sm btn-warning" id="btnHistoryBack">Back</button>
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
  window.setInterval(function(){
    updateStats();
    updateTable();
  }, 2000);

  $('#loggedin').delay(2000).slideUp(1000);

  $('#btnConverter').click(function() {
    $('#homePanel').delay(500).slideUp(500);
    $('#converterPanel').delay(1500).slideDown(500);
  });

  $('#btnHistory').click(function() {
    $('#homePanel').delay(500).slideUp(500);
    $('#historyPanel').delay(1500).slideDown(500);
    updateTable()
  });

  $('#btnHistoryBack').click(function() {
    $('#historyPanel').delay(500).slideUp(500);
    $('#homePanel').delay(1500).slideDown(500);
  });

  $('#btnStatistics').click(function() {
    $('#homePanel').delay(500).slideUp(500);
    $('#statisticPanel').delay(1500).slideDown(500);
    updateStats()
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
    if ((numberVal).length != 0) {
      if(numberVal > 0) {
        if(numberVal < 5000) {
          $('#converterErrors').html('');
          $.ajax({
            type: 'post',
            url: '{{ route("convertNumeral") }}',
            data: {_token: CSRF_TOKEN,'numberVal':numberVal},
            success:function(data){
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
      } else {
        $('#converterErrors').html('<i class="fa fa-lg fa-exclamation-triangle"></i> You need to enter a value above 0!');
      };

    };
  });

});

function updateStats() {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    type: 'post',
    url: '{{ route("getStats") }}',
    data: {_token: CSRF_TOKEN},
    success:function(data){
      if ($('#totalUsersVal').text() != data[0]) {
        $('#totalUsers').text(data[0]);
        $('#totalUsersVal').text(data[0]);
      }

      if ($('#totalConversionsVal').text() != data[1]) {
        $('#totalConversions').text(data[1]);
        $('#totalConversionsVal').text(data[1]);
      }

      if ($('#popNumberVal').text() != data[2]) {
        $('#popNumber').text(data[2]);
        $('#popNumberVal').text(data[2]);
      }

      $('#mostConversions').text(data[3]);


    },
    error:function(data){
      console.log(data);
    },
  });//end ajax
}

function updateTable() {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    type: 'post',
    url: '{{ route("getTable") }}',
    data: {_token: CSRF_TOKEN},
    success:function(data){
      $('#historyTable').empty();
      $('<thead align="center">').append(
      $('<tr>').append(
      $('<th>').text("UserName"),
      $('<th>').text("Original Number"),
      $('<th>').text("Roman Numeral"),
      $('<th>').text("Timestamp"))).appendTo('#historyTable');
      data = $.parseJSON(data);
      $.each(data, function(i, item) {
        $('<tbody>').append(
            $('<tr>').append(
            $('<td>').text(item.userID),
            $('<td>').text(item.orgNumber),
            $('<td>').text(item.romNumeral),
            $('<td>').text(item.created_at))).appendTo('#historyTable');
    });

    },
    error:function(data){
      console.log(data);
    },
  });//end ajax
}

</script>
@endsection
