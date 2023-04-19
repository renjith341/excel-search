<!DOCTYPE html>
<html>

<head>
  <title>Excel Search Engine</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
    $(function() {
      var valMap = ['0GB', '250GB', '500GB', '1TB', '2TB', '3TB', '4TB', '8TB', '12TB', '24TB', '48TB', '72TB'];
      $("#slider-range").slider({
        range: true,
        min: 0,
        max: valMap.length - 1,
        values: [2, 5],
        slide: function(event, ui) {
          $("#storage").val(valMap[ui.values[0]] + " - " + valMap[ui.values[1]]);
          $('#storageFrom').val(valMap[ui.values[0]]);
          $('#storageTo').val(valMap[ui.values[1]]);
        }
      });

      $("#storage").val(valMap[$("#slider-range").slider("values", 0)] +
        " - " + valMap[$("#slider-range").slider("values", 1)]);
      $('#storageFrom').val(valMap[$("#slider-range").slider("values", 0)]);
      $('#storageTo').val(valMap[$("#slider-range").slider("values", 1)]);
    });
  </script>
</head>

<body>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header text-center font-weight-bold">
        Excel Search Engine
      </div>

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="card-body">
        <form name="excel-search-form" id="excel-search-form" method="post" action="{{url('search')}}">
          @csrf
          <div class="form-group">
            <p>
              <label for="storage">Storage:</label>
              <input type="hidden" name="storageFrom" id="storageFrom">
              <input type="hidden" name="storageTo" id="storageTo">
              <input type="text" id="storage" name="storage" readonly style="border:0; color:#f6931f; font-weight:bold;">
            </p>
            <div id="slider-range"></div>
          </div>
          <br />
          <div class="form-group">
            <label for="storage">RAM </label>

            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option1" value="2">
              <label class="form-check-label" for="option1">2GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option2" value="4">
              <label class="form-check-label" for="option2">4GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option3" value="8">
              <label class="form-check-label" for="option3">8GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option4" value="12">
              <label class="form-check-label" for="option4">12GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option5" value="16">
              <label class="form-check-label" for="option5">16GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option6" value="24">
              <label class="form-check-label" for="option6">24GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option7" value="32">
              <label class="form-check-label" for="option7">32GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option8" value="48">
              <label class="form-check-label" for="option8">48GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option9" value="64">
              <label class="form-check-label" for="option9">64GB</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="ram[]" type="checkbox" id="option10" value="96">
              <label class="form-check-label" for="option10">96GB</label>
            </div>

          </div>
          <br />

          <div class="form-group">
            <select class="form-select" aria-label="Select Harddisk Type" name="harddiskType">
              <option selected value="">Select Harddisk Type</option>
              <option value="SAS">SAS</option>
              <option value="SATA">SATA</option>
              <option value="SSD">SSD</option>
            </select>
          </div>
          <br />

          <div class="form-group">
            <select class="form-select" aria-label="Select Location" name="location">
              <option selected value="">Select Location</option>
              <option value="AmsterdamAMS-01">AmsterdamAMS-01</option>
              <option value="DallasDAL-10">DallasDAL-10</option>
              <option value="FrankfurtFRA-10">FrankfurtFRA-10</option>
              <option value="Hong KongHKG-10">Hong KongHKG-10</option>
              <option value="San FranciscoSFO-12">San FranciscoSFO-12</option>
              <option value="SingaporeSIN-11">SingaporeSIN-11</option>
              <option value="Washington D.C.WDC-01">Washington D.C.WDC-01</option>
            </select>
          </div>
          <br />

          <button type="submit" class="btn btn-primary">Submit</button>

        </form>
      </div>
    </div>

  </div>
</body>

</html>
