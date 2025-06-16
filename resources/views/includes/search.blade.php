<!--Search Form-->
<div class="main-search-form transition-02s">
    <div class="container">
        <div class="pt-50 pb-50 main-search-form-cover">
            <div class="row mb-20">
                <div class="col-12">
                    <form action="{{ route('search-article') }}" method="get" class="search-form position-relative" autocomplete="off">
                        <div class="search-form-icon"><i class="ti-search"></i></div>
                        <label>
                            <input type="text" name="keyword" class="search_field" id="search_field" placeholder="Enter keywords for search..." value="" name="s">
                        </label>
                        <div class="search-switch">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="#" class="active">Articles</a></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('addon-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>

var path = "{{ route('autocomplete') }}";

$('#search_field').typeahead({

    source: function(query, process){

        return $.get(path, {query:query}, function(data){

            return process(data);

        });

    }

});
</script>
@endpush