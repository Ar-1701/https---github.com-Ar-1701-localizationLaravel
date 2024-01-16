<select class="form-select" id='lang' name="lang" onchange="langs()">
    @foreach ($lang as $lang)
        @if (Session::get('lang') == $lang->lang)
            <option selected value="{{ $lang->id }}">{{ $lang->lang }}</option>
        @else
            <option value="{{ $lang->id }}">{{ $lang->lang }}</option>
        @endif
    @endforeach
</select>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    function langs() {
        var lang = $("#lang").val();
        // alert(lang)
        $.ajax({
            url: "{{ url('langs') }}",
            type: "post",
            data: {
                lang_id: lang,
                _token: "{{ @csrf_token() }}"
            },
            success: function(data) {
                // let obj = JSON.parse(data)
                // $("#postTitle").html(data.word);
                location.reload();
                // console.log(data)
            }
        });
    }
</script>
