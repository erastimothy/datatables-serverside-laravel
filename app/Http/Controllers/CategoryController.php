<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = Category::with('books')->latest();
            return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action',function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory">Edit</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory">Delete</a>';
                            return $btn;
                        })
                        ->addColumn('details_url', function($row) {
                            return route('categories.show', $row->id);
                        })
                        ->rawColumns(['action'])
                        ->make(true);
        }
        return view('categories.index',[
            'category' => new Category(),
        ]);
    }
    
    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back();
    }

    public function show($id){
    
        if(request()->ajax()){
            $data = Book::where('category_id','=',$id)->get();
            return DataTables::of($data)
                        ->addIndexColumn()
                        ->rawColumns(['action'])
                        ->make(true);
        }
    }

    public function edit($id)
    {
        return view('categories.edit',[
            'title' => 'Edit Category',
            'action' => 'Save',
            'category' => Category::find($id),
        ]);
    }

    
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('categories.index');
    }

   
    public function destroy($id)
    {
        $Category = Category::findOrFail($id)->delete();
        return response()->json([
            'icon'=>'success',
            'title' => 'Berhasil',
            'message' => 'Berhasil menghapus data']
        ,200);
    }
}
