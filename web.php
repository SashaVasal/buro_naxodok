<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
Route::get('/', function () {
    $cat = App\Category::all();
    return view('welcome',["results"=>$cat]);
});
Route::get('/test',function(){
    App\Category::create([
        "name"=>"Любимые фильмы"
    ]);
});

Route::get('/post/{id}',function($id){
    $post = App\Category::find($id);
     //$post = App\Post::where('categories_id', $id)->get();
    $comments=$post->comments; 
    return view('post',["post"=>$post]);
});
Route::get('/datails/{id}',function($id){
     $cat = App\Category::all();
    $post = App\Post::where('categories_id', $id)->get();
    return view('datails',["results"=>$post,'links'=>$cat]);
    
});
Route::post('/addComent/{id}',function(Request $req,$id){
    App\Comment::create([
        "user_name"=>$req->user,
        "body"=>$req->body,
        "post_id"=>$id
    ]);
    
});
Route::get('/admin',function(){
    return view('admin');
    
});
Route::post('/addPomt',function(Request $req){
   
     $url=Storage::url($image);
    App\Post::create([
        "title"=>$req->post_title,
        "body"=>$req->post_body,
        "categories_id"=>1,
        "image"=>$url
    ]
    
    );
   
});

Route::get('/addPost',function(Request $req){
     header('Access-Control-Allow-Origin:*');
   /*App\Item::create([
        "description"=>$req->description,
        "title"=>$req->title,
        "contact"=>$req->contact,
        "status"=>$req->status,
        ]
    ); */
    $id = DB::table('items')->insertGetId( ['title' => $req->title, 'contact' => $req->contact, 'description' => $req->description,"status"=>$req->status, ]);
    return $id;

    
});

Route::get('/ajax',function(Request $req){
    header('Access-Control-Allow-Origin:*');
    $post = App\Post::where('id', 2)->get();
    return $post;
});
Route::get('/getAll',function(Request $req){
    header('Access-Control-Allow-Origin:*');
    $items = App\Item::all();
    return $items;
});
Route::get('/lost',function(Request $req){
    header('Access-Control-Allow-Origin:*');
   $item = App\Item::where('status', 0)->get();
    return $item;
});
Route::get('/found',function(Request $req){
    header('Access-Control-Allow-Origin:*');
   $item = App\Item::where('status', 1)->get();
    return $item;
});
Route::get('/find',function(Request $req){
    header('Access-Control-Allow-Origin:*');
    $item = App\Item::where('title',"like" ,'%'.$req->test."%")->orWhere('description',"like" ,'%'.$req->test."%")->get();
    return $item;
});
Route::get('/SeePost',function(Request $req){
    header('Access-Control-Allow-Origin:*');
   // @foreach($req->id_post as $req->id_post)
        //$item = App\Item::where("id",$req ->id_post[$i])->get();
        //return $item;
   // @endforeach
    //for($i = 0; $i<count($req->test); $i++){
        //$item = App\Item::where('id',$req->id_post[$i])->get();
        
   // }
    $emptyArray = array();
    $array =  json_decode($req->test);
    for($i = 0; $i < count($array); $i++){
        $item = App\Item::where('id',$array[$i])->get();
        array_push($emptyArray, $item);
    }  
    
    return $emptyArray;
    
});
Route::get('/delete_post',function(Request $req){
    header('Access-Control-Allow-Origin:*');
   $painters = App\Item::find($req->delete_id);
    $painters ->delete();
});

