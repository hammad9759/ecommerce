@foreach($childCategories as $childCategory)
    <option value="{{ $childCategory->id }}"  {{ $childCategory->id == $product->category_id ? 'selected' : '' }}>{{ $prefix }} {{ $childCategory->name }}</option>
    @if($childCategory->children->isNotEmpty())
        @include('admin.products.partials.child-categoriesEdit', ['childCategories' => $childCategory->children, 'prefix' => $prefix . '--'])
    @endif
@endforeach