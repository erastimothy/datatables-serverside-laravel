@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<section class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#formModal">
                Create New Category
            </button>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered data-table" width="100%s" id="data-table">
                <thead>
                    <tr>
                        <th width="20"></th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>
    
    
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Create New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    @include('categories.form-control')
            </div>
            <div class="modal-footer justify-content-between">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script id="details-template" type="text/x-handlebars-template">
        @verbatim
        <div class="label label-info">Book's with category <strong>{{ name }}</strong></div><br>
        <table class="table details-table" id="category-{{id}}">
            <thead>
            <tr>
                <th>Book Title</th>
                <th>ISBN</th>
                <th>Price ($)</th>
            </tr>
            </thead>
        </table>
        @endverbatim
    </script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
    <script type="text/javascript"> 
        $(function () {
            var template = Handlebars.compile($("#details-template").html());
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns: [
                    {
                        "className": 'details-control td-details',
                        "orderable": false,
                        "searchable": false,
                        "defaultContent": '<span><i class="fa fa-plus"></i></span>'
                    },
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(".data-table tbody").on('click','td,details-control',function(){
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var tableId = 'category-'+row.data().id;

                if(row.child.isShown()){
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).closest('.td-details').html('<span><i class="fa fa-plus"></i></span>')
                }else {
                    row.child(template(row.data())).show();
                    initTable(tableId, row.data());
                    tr.addClass('shown');
                    $(this).closest('.td-details').html('<span><i class="fa fa-minus"></i></span>')
                    tr.next().find('td').addClass('no-padding bg-gray');
                }
            });

            function initTable(tableId, data) {
                $('#' + tableId).DataTable({
                processing: true,
                serverSide: true,
                ajax: data.details_url,
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'isbn', name: 'isbn' },
                    { data: 'price', name: 'price'}
                ]
                })
            }
            
            //Edit item
            $('body').on('click','.editCategory', function(){
                let id = $(this).data("id");
                let url = window.location.href;
                //redirect to
                window.location.href = url+"/"+id+"/edit";
            })

            //Delete item
            $('body').on('click','.deleteCategory', function(){
                let id = $(this).data("id");
                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: "Jika menekan tombol Yakin, Maka data akan terhapus sepenuhnya dan tidak dapat dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin!',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: window.location.href+'/'+id,
                            success: function (data) {
                                table.draw();
                                Swal.fire({
                                    icon: data.icon,
                                    title: data.title,
                                    text: data.message,
                                })
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: data.responseJSON.icon,
                                    title: data.responseJSON.title,
                                    text: data.responseJSON.message,
                                })
                            }
                        });
                    }
                })
            });


        });

        
    </script>
@endpush