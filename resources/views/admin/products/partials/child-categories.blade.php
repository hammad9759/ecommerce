@foreach($childCategories as $childCategory)
    <option value="{{ $childCategory->id }}">{{ $prefix }} {{ $childCategory->name }}</option>
    @if($childCategory->children->isNotEmpty())
        @include('admin.products.partials.child-categories', ['childCategories' => $childCategory->children, 'prefix' => $prefix . '--'])
    @endif
@endforeach