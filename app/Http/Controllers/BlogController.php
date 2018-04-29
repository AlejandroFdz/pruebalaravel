<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Blog;

use Barryvdh\Debugbar\Facade as Debugbar;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $is_admin = 0;

        if (Auth::check()) {
            $result = User::where('id', '=', Auth::user()->id)->pluck('admin');
            $is_admin = $result[0];
        }

        $posts = Blog::orderBy('id', 'desc')->get();

        return view('blog.index', compact('is_admin', $is_admin))->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( isset($request->create_picture_filename) ) {

            $year_folder = date('Y');
            $month_folder = date('m');

            if( file_exists( storage_path('uploads/blog/' . $year_folder) === false ) ) {
                mkdir( storage_path('uploads/blog/' . $year_folder) );
            }

            if( file_exists( storage_path('uploads/blog/') . $year_folder . '/' . $month_folder ) ) {
                mkdir( storage_path('uploads/blog/') . $year_folder . '/' . $month_folder );
            }

            $upload_folder = 'uploads/blog/' . $year_folder . '/' . $month_folder;

            $path = $request->file('featured_picture')->store($upload_folder);

            $blog = new Blog(array(
                'title' => $request->title,
                'featured_picture' => $path,
                'content' => $request->body
            ));

        } else {

            $blog = new Blog(array(
                'title' => $request->title,
                'content' => $request->body
            ));

        }

        $blog->save();

        return redirect('blog');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return redirect('blog');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {   
        $is_admin = 0;

        if (Auth::check()) {
            $result = User::where('id', '=', Auth::user()->id)->pluck('admin');
            $is_admin = $result[0];
        }
        
        $post = Blog::where('id', '=', $id)->get();

        return view('blog.edit', compact('is_admin'))->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {   

        $post = Blog::where('id', '=', $id)->get();

        if( isset($request->featured_picture) ) {

            if($post[0]->featured_picture != "") {
                
                $picture_folder_str = $post[0]->featured_picture;
                $picture_folder_array = explode('/', $picture_folder_str);
                
                $year_folder = $picture_folder_array[2];
                $month_folder = $picture_folder_array[3];
            
            } else {

                $year_folder = date('Y');
                $month_folder = date('m');

                if( file_exists( storage_path('uploads/blog/' . $year_folder) === false ) ) {
                    mkdir( storage_path('uploads/blog/' . $year_folder) );
                }

                if( file_exists( storage_path('uploads/blog/') . $year_folder . '/' . $month_folder ) ) {
                    mkdir( storage_path('uploads/blog/') . $year_folder . '/' . $month_folder );
                }

            }

            $upload_folder = 'uploads/blog/' . $year_folder . '/' . $month_folder;

            $path = $request->file('featured_picture')->store($upload_folder);

            Blog::where('id', '=', $id)->update([
                'title' => $request->title,
                'featured_picture' => $path,
                'content' => $request->body
            ]);

        } else {

            Blog::where('id', '=', $id)->update([
                'title' => $request->title,
                'content' => $request->body
            ]);
        }

        return redirect('blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {

        Blog::destroy($id);

        return redirect('blog');
    }
}
