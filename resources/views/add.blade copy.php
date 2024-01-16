<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('show_post') }}">Show Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">show By Language</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('add_post') }}">Add Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('posts') }}">All Post</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <h1>Add Post</h1>
            </div>
        </div>
    </div>
    <form id="add_form" class="row g-3 w-50 m-auto border border-3 p-1">
        @csrf
        <?php if (count($singleLang)>0){ ?>
        @foreach ($singleLang as $item)
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Title - {{ $item->lang }}</label>
                <input type="hidden" name='locale' id='locale' value="{{ $item->id }}" class="form-control">
                <input type="hidden" name='id' id='id' value="{{ $singleData->id }}" class="form-control">
                <input type="text" name='title' id='title' value="{{ $singleData->post_title }}"
                    class="form-control"placeholder="Title">
            </div>
            <div class="col-md-12">
                <label for="inputPassword4" class="form-label">Post Category - {{ $item->lang }}</label>
                <input type="text"name='post_cat' id='post_cat' class="form-control"
                    placeholder="Category"value="{{ $singleData->post_cat }}">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Description - {{ $item->lang }}</label>
                <textarea rows="5" class="form-control"name='post_desc' id='post_desc' placeholder="Description">{{ $singleData->post_desc }}
                    </textarea>
            </div>
        @endforeach
        <?php } else{ ?>
        @foreach ($lang as $item)
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Title - {{ $item->lang }}</label>
                <input type="hidden" name='locale[]' id='locale' value="{{ $item->id }}" class="form-control">
                <input type="text" name='title[]' id='title' value=""
                    class="form-control"placeholder="Title">
            </div>
            <div class="col-md-12">
                <label for="inputPassword4" class="form-label">Post Category - {{ $item->lang }}</label>
                <input type="text"name='post_cat[]' id='post_cat' class="form-control"
                    placeholder="Category"value="">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Description - {{ $item->lang }}</label>
                <textarea rows="5" class="form-control"name='post_desc[]' id='post_desc' placeholder="Description"></textarea>
            </div>
        @endforeach
        <?php }?>
        <div class="col-12">
            <label for="inputAddress2" class="form-label">Image</label>
            <input type="file" class="form-control" id="img"name="img">
            @if (isset($singleData))
                <img src="{{ asset('public/upload/post/' . $singleData->post_img) }}" class="img-fluid w-25 m-auto"
                    alt="" srcset="">
                <input type="hidden" name="old_img"value="{{ $singleData->post_img }}">
            @endif
        </div>
        <div class="col-12">
            <button type="button" id="add_btn" class="btn btn-primary">Add</button>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        $("#add_btn").click(function() {
            $.ajax({
                url: "{{ url('save_post') }}",
                type: "post",
                data: new FormData($("#add_form")[0]),
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                    if ($.trim(data) == "save") {
                        window.location = "{{ url('/') }}";
                    }
                    if ($.trim(data) == "update") {
                        window.location = "{{ url('/') }}";
                    }
                }
            });
        });
    </script>
</body>

</html>
