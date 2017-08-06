{{ csrf_field() }}

{{-- Title --}}
<div class="form-group">
    <label for="title" class="label">Title</label>
    <input class="form-control" id="title" name="title">
</div>

{{-- Description --}}
<div class="form-group">
    <label for="description" class="label">Description</label>
    <input class="form-control" id="description" name="description">
</div>

{{-- Keywords --}}
<div class="form-group">
    <label for="keywords" class="label">Keywords</label>
    <input class="form-control" id="keywords" name="keywords">
</div>

{{-- Body --}}
<div class="form-group">
    <label for="body" class="label">Body</label>
    <textarea class="form-control" id="body" name="body"></textarea>
</div>

{{-- Submit Button --}}
<div class="form-group">
    <button class="btn btn-primary" type="submit">Post article</button>
</div>