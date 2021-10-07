<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name') ?? $category->name }}" class="form-control" required placeholder="category name">
    @error('name')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>
