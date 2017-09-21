{{ csrf_field() }}

<div class="form-group">
    <label for="tag" class="label">{{ __('tags.form.name') }}</label>
    <input id="tag" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
           value="@if(isset($tag)){{ old('name',$tag->name) }}@else{{ old('name') }}@endif">

    @if ($errors->has('name'))
        <div class="invalid-feedback">
            {{ $errors->first('name') }}
        </div>
        <small class="form-text text-muted">{{ __('tags.error.check_tag') }}</small>
    @endif
</div>

<div class="form-group">
    <button class="btn btn-primary" type="submit">{{ __('tags.form.submit') }}</button>
</div>