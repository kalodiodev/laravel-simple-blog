<form>
    <div class="form-row">
        <div class="col">
            <input class="form-control mb-3 mb-sm-3"
                   name="search"
                   id="search"
                   placeholder="{{ __('partials.search.placeholder') }}"
                   value="@if(isset($search)){{ old('search', $search) }}@endif">
        </div>

        <div class="col-auto">
            <button class="btn btn-primary">{{ __('partials.search.button') }}</button>
        </div>
    </div>
</form>