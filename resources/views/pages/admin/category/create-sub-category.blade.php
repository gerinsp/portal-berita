@php $dash.='-- '; @endphp
@foreach($subcategories as $subcategory)
    <option value="{{$subcategory->id}}">{{$dash}}{{$subcategory->name}}</option>
    @if(count($subcategory->subcategory))
        @include('pages.admin.category.create-sub-category',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach