<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Show All Post</title>
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
                    <li>
                        @include('lang')
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 style="text-align:center" id="postTitle">{{ __('text.postTitle') }}</h2>
                <div class="row">
                    <table class="table text-center table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Desc</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($post as $row)
                                <tr>
                                    <th scope="row">{{ $row->id }}</th>
                                    <td>{{ $row->post_title }}</td>
                                    <td>{{ $row->post_cat }}</td>
                                    <td>{{ substr($row->post_desc, 0, 200) }}</td>
                                    <td><img src="{{ asset('public/upload/post/' . $row->post_img) }}"
                                            class="img-fluid w-25 text-center" alt="" srcset="">
                                    </td>
                                    <td>
                                        <a href="{{ url('add_post?lang_id=') . $row->language_id . '&post_id=' . $row->post_id . '&id=' . $row->id }}"
                                            class="btn text-center text-light btn-primary">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
