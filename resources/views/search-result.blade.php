<!DOCTYPE html>
<html>
<head>
    <title>Excel Search Engine</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-4">
  
  <div class="card">
    <table class="table table-striped table-hover">
    <thead class="thead-light">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Model</th>
        <th scope="col">Ram</th>
        <th scope="col">HDD</th>
        <th scope="col">Location</th>
        <th scope="col">Price</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($serverList as $key => $serverInfo)
        <th scope="row">{{ $key+1 }}</th>
        <td>{{ $serverInfo->getModel() }}</td>
        <td>{{ $serverInfo->getRam() }}</td>
        <td>{{ $serverInfo->getStorage() }}</td>
        <td>{{ $serverInfo->getLocation() }}</td>
        <td>{{ $serverInfo->getPrice() }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>

<a class="btn btn-primary" href="/search" role="button">Back</a>

</div>  
</body>
</html>
