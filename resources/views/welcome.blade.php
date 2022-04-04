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
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('excel') }}</strong>
                                    </span>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Upload
            </button>
        </div>

        <div class="progress mt-5 mb-4">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <a href="/rows" id="btn-rows" class="btn btn-warning">Rows</a>
    </form>

</div>
</body>
<script>
    let form = document.querySelector('form')
    let excelInput = document.querySelector('#excel')
    let errorField = document.querySelector('.invalid-feedback strong')
    let progressBar = document.querySelector('.progress-bar')

    document.querySelector('.progress').style.display = 'none'
    document.querySelector('#btn-rows').style.display = 'none'

    document.querySelector('button').addEventListener('click', function (e) {
        e.preventDefault()

        document.querySelector('.progress').style.display = ''
        progressBar.style.width = 0

        let data = new FormData(form)
        fetch('/upload', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: data
        })
            .then(res => {
                    return res.json()
            })
            .then(({channel, errors}) => {
                if (errors) {
                    if (!excelInput.classList.contains('is-invalid')) {
                        excelInput.classList.add('is-invalid')
                    }

                    errorField.innerHTML = errors[Object.keys(errors)[0]]
                } else {
                    window.Echo.channel('processing.' + channel)
                        .listen('Processing', ({percent}) => {
                            progressBar.style.width = percent + '%'

                            if (percent === 100) {
                                document.querySelector('#btn-rows').style.display = ''
                            }
                        })
                    excelInput.classList.remove('is-invalid')
                }
            })
    })
</script>
</html>

