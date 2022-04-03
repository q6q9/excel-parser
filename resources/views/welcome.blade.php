<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="/js/app.js"></script>
    <title>Laravel</title>
    <script src="//127.0.0.1:6001/socket.io/socket.io.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center bg-dark">
<div>
    <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data"
          class="p-5 rounded mt-5 w-100 bg-white">
        @csrf
        <div class="form-group mb-4">
            <label for="excel" class="h3">Excel:</label>
            <div class="">
                <input id="excel" type="file" class="form-control {{ $errors->has('excel') ? ' is-invalid' : '' }}"
                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                       name="excel" value="{{ old('excel') }}" autofocus/>
                @if ($errors->has('excel'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('excel') }}</strong>
                                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Upload
            </button>
        </div>
    </form>
</div>
</body>
<script>
    // window.Echo.channel('processing')
    //     .listen('Processing', (percent) => {
    //         console.log(percent)
    //     })

    let form = document.querySelector('form')
    document.querySelector('button').addEventListener('click', function (e) {
        e.preventDefault()

        let data = new FormData(form)
        fetch('/upload', {
            method: 'POST',
            body: data
        })
            .then(res => res.json())
            .then(({channel}) => {
                window.Echo.channel('processing.' + channel)
                    .listen('Processing', ({percent}) => {
                        console.log(percent)
                    })
            })
    })
</script>
</html>

