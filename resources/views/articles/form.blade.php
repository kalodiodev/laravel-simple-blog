{{ csrf_field() }}

{{-- Title --}}
<div class="form-group">
    <label for="title" class="label">{{ __('articles.form.title') }}</label>
    <input class="form-control" id="title" name="title"
           value="@if(isset($article)){{ old('title',$article->title) }}@else{{ old('title') }}@endif">
</div>

{{-- Description --}}
<div class="form-group">
    <label for="description" class="label">{{ __('articles.form.description') }}</label>
    <input class="form-control" id="description" name="description"
           value="@if(isset($article)){{ old('description',$article->description) }}@else{{ old('description') }}@endif">
</div>

{{-- Keywords --}}
<div class="form-group">
    <label for="keywords" class="label">{{ __('articles.form.keywords') }}</label>
    <input class="form-control" id="keywords" name="keywords"
           value="@if(isset($article)){{ old('keywords',$article->keywords) }}@else{{ old('keywords') }}@endif">
</div>

{{-- Featured Image --}}
<div class="form-group">
    <label for="image" class="label">{{ __('articles.form.featured') }}</label>
    <input class="form-control" id="image" name="image" type="file">
</div>

{{-- Remove image --}}
@if(isset($article) && ($article->hasImage()))
    <div class="form-group">
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox"
                       class="form-check-input"
                       name="removeimage"
                       id="removeimage"> {{ __('articles.form.remove_image') }}
            </label>
        </div>
    </div>
@endif



{{-- Body --}}
<div class="form-group">
    <label for="body" class="label">{{ __('articles.form.body') }}</label>
    <textarea class="form-control" id="body"
              name="body">@if(isset($article)){{ old('body',$article->body) }}@else{{ old('body') }}@endif</textarea>
</div>

{{-- Tags --}}
<div class="form-group">
    <label for="tags" class="label">{{ __('articles.form.tags') }}</label>
    <select multiple class="form-control" id="tags" name="tags[]">
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}"
                    @if(isset($article) && in_array($tag->id, $article->tags()->pluck('id')->toArray()))
                    selected
                    @endif
            >{{ $tag->name }}</option>
        @endforeach
    </select>
</div>

{{-- Submit Button --}}
<div class="form-group">
    <button class="btn btn-primary" type="submit">{{ __('articles.button.post') }}</button>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif