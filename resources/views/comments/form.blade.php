{{ csrf_field() }}

<div class="form-group">
    <label for="comment" class="label">{{ __('comments.form.title') }}</label>
    <textarea id="comment" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body"
    >@if(isset($comment)){{ old('body',$comment->body) }}@else{{ old('body') }}@endif</textarea>

    @if ($errors->has('body'))
        <div class="invalid-feedback">
            {{ $errors->first('body') }}
        </div>
        <small class="form-text text-muted">{{ __('comments.error.check_comment') }}</small>
    @endif
</div>

<div class="form-group">
    <button class="btn btn-primary" type="submit">{{ __('comments.form.submit') }}</button>
</div>
