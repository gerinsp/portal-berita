@php
 $dash.='-- ';   
@endphp 
@foreach($subcategories as $subcategory)
    <tr>
        <td></td>
        <td>{{$dash}}{{$subcategory->name}}</td>
        <td>{{$subcategory->slug}}</td>
        <td>
            <a class="btn btn-primary btn-xs" href="{{ route('category.edit', $subcategory->id) }}">
                <i class="fas fa-edit"></i> &nbsp; Ubah
            </a>
            <form action="{{ route('category.destroy', $subcategory->id) }}" method="POST" onsubmit="return confirm('Anda akan menghapus item ini secara permanen dari situs anda?')">
                @method('delete')
                @csrf
                <button class="btn btn-danger btn-xs">
                    <i class="far fa-trash-alt"></i> &nbsp; Hapus
                </button>
            </form>
        </td>
    </tr>
    @if(count($subcategory->subcategory))
        @include('pages.admin.category.list-sub-category',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach