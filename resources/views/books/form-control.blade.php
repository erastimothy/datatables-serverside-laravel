<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title') ?? $book->title }}" class="form-control" required placeholder="book title">
    @error('title')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="category">Category</label>
    <select name="category" id="category" required class="form-control">
        <option value="">-- Select Category --</option>
        @foreach ($categories as $category)
            <option {{ $category->id == $book->category_id || old('category') ? 'selected' : ''  }} value="{{$category->id}}"> {{$category->name}}</option>
        @endforeach
    </select>
    @error('category')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="price">Price</label>
    <input type="number" name="price" id="price" value="{{ old('price') ?? $book->price }}" class="form-control" required placeholder="price $">
    @error('price')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="isbn">Isbn</label>
    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') ?? $book->isbn }}" class="form-control" required placeholder="isbn">
    @error('isbn')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="summary">Summary</label>
    <textarea name="summary" id="summary" cols="30" rows="5" class="form-control" required placeholder="summary">{{ old('summary') ?? $book->summary}}</textarea>
    @error('summary')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>