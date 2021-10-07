<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = Book::with('category')->latest();
            return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action',function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
        }
        return view('books.index',[
            'book' => new Book(),
            'categories' => Category::orderBy('name')->get(['id','name']),
        ]);
    }


    
    public function store(BookRequest $request)
    {
        Book::create([
            'title' => $request->title,
            'category_id' => $request->category,
            'price' => $request->price,
            'isbn' => $request->isbn,
            'summary' => $request->summary,
        ]);

        return redirect()->back();
    }

    

    
    public function edit($id)
    {
        return view('books.edit',[
            'title' => 'Edit Book',
            'action' => 'Save',
            'categories' => Category::orderBy('name')->get(['id','name']),
            'book' => Book::find($id),
        ]);
    }

    
    public function update(BookRequest $request, $id)
    {
        $book = Book::find($id)->update([
            'title' => $request->title,
            'category_id' => $request->category,
            'price' => $request->price,
            'isbn' => $request->isbn,
            'summary' => $request->summary,
        ]);
        return redirect()->route('books.index');
    }

   
    public function destroy($id)
    {
        $book = Book::findOrFail($id)->delete();
        return response()->json([
            'icon'=>'success',
            'title' => 'Berhasil',
            'message' => 'Berhasil menghapus data']
        ,200);
    }
}
