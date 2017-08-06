{{ csrf_field() }}

{{-- Title --}}
<div class="form-group">
    <label for="title" class="label">Title</label>
    <input class="form-control" id="title" name="title"
           value="@if(isset($article)){{ old('title',$article->title) }}@else{{ old('title') }}@endif">
</div>

{{-- Description --}}
<div class="form-group">
    <label for="description" class="label">Description</label>
    <input class="form-control" id="description" name="description"
           value="@if(isset($article)){{ old('description',$article->description) }}@else{{ old('description') }}@endif">
</div>

{{-- Keywords --}}
<div class="form-group">
    <label for="keywords" class="label">Keywords</label>
    <input class="form-control" id="keywords" name="keywords"
           value="@if(isset($article)){{ old('keywords',$article->keywords) }}@else{{ old('keywords') }}@endif">
</div>

{{-- Body --}}
<div class="form-group">
    <label for="body" class="label">Body</label>
    <textarea class="form-control" id="body"
              name="body">@if(isset($article)){{ old('body',$article->body) }}@else{{ old('body') }}@endif</textarea>
</div>

{{-- Submit Button --}}
<div class="form-group">
    <button class="btn btn-primary" type="submit">Post article</button>
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