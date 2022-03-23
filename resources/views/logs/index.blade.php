@extends('layout.page.content')

@section('title', 'Logs Manager')

@section('page_title', 'Log files')

@section('content')

    <table
        id="table"
        data-toggle="table"
        data-height="auto"
        data-search="true"
        data-search-align="left"
        data-pagination="true"
        data-page-size=5
        data-page-list="[5, 12, 25, 50, 100, All]"
        data-pagination-successively-size=3
        data-loading-template="loadingTemplate"
        data-url="{{ route("logs.data") }}">
        <thead>
            <tr>
                <th data-field="basename">File</th>
            </tr>
        </thead>
    </table>

    <x-modalConfirm 
        title="Delete Category"
        message="Are you sure you want to delete this category?"
        label="Confirm"
        method="DELETE"
    />

    <script>
        function editID(value) {
            return "<a href='{{ route('category.index') }}/"+value+"' title='Edit Process Category'>" +
                    editIcon()+"</a>";
        }

        function deleteCategory(value) {
            return "<a href='#' onClick=actionModal('{{ route('category.index') }}/"+value+"') title='Delete Category'>"+
                        "<i class='fas fa-trash-alt'></i>"+
                    '</a>';
        }
    </script>

@endsection
