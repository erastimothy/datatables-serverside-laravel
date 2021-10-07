@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<section class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#formModal">
                Create New Book
            </button>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered data-table" width="100%s">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>ISBN</th>
                        <th>Summary</th>
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
                    <h5 class="modal-title" id="formModalLabel">Create New Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf
                        @include('books.form-control')
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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript"> 
        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('books.index') }}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'category.name', name: 'category.name'},
                    {data: 'price', name: 'price'},
                    {data: 'isbn', name: 'isbn'},
                    {data: 'summary', name: 'summary'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            //Edit item
            $('body').on('click','.editBook', function(){
                let id = $(this).data("id");
                let url = window.location.href;
                //redirect to
                window.location.href = url+"/"+id+"/edit";
            })

            //Delete item
            $('body').on('click','.deleteBook', function(){
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