<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

use Exception;
use PhpParser\Node\Stmt\TryCatch;

class PostController extends Controller
{
   

    public function store(CreatePostRequest $request){
       
       try {
        $post=new Post();
        $post->titre=$request->titre;
        $post->description=$request->description;
        $post->user_id=auth()->user()->id;
        $post->save();
        return response()->json([
            'status_code'=>200,
            'status_message'=>'le post a été créer',
            'data'=>$post

        ]);

       } catch (Exception $e){

        return response()->json(['error' => 'Une erreur est produite'], 500);

       
    }
}

       public function update(EditPostRequest $request, Post $post){

        //$post=Post::find($id);
        


        try {
            
            $post->titre=$request->titre;
            $post->description=$request->description;
            if($post->user_id===auth()->user()->id)
            {
                $post->save();

            }else
            {
                return response()->json([
                    'status_code'=>422,
                    'status_message'=>'vous n\'etes pas l\'auteur de ce post',
                    
        
                ]);

            }
            
            return response()->json([
                'status_code'=>200,
                'status_message'=>'le post a été modifier',
                'data'=>$post
    
            ]);
    
           } catch (Exception $e){
    
            return response()->json(['error' => 'Une erreur est produite'], 500);
    
           
        }
        

       }

       public function delete(Post $post){
        try {
           

            if($post->user_id===auth()->user()->id)
            {
                $post->delete();

            }else
            {
                return response()->json([
                    'status_code'=>422,
                    'status_message'=>'vous n\'etes pas l\'auteur de ce post ,suppression non autorisé',
                    
        
                ]);

            }


                
                 return response()->json([
                'status_code'=>200,
                'status_message'=>'le post a été supprimé',
                'data'=>$post
    
            ]);

           
                //$post->delete();
               
            
    
           } catch (Exception $e){
    
            return response()->json(['error' => 'Une erreur est produite'], 500);
    
           
        }


       }

       public function index(Request $request){

        
        try {
            $query=Post::query();
        $perPage= 2;
        $page=$request->input('page',1);
        $search=$request->input('search');
        if($search){
            $query->whereRaw("titre LIKE '%" .$search. "%'");
        }
        $total=$query->count();
        $result=$query->offset(($page - 1) * $perPage)->limit($perPage)->get();
            
            return response()->json([
                'status_code'=>200,
                'status_message'=>'les posts ont été récupéré',
                //'data'=>Post::all(),
                'current_page'=>$page,
                'last_page'=>ceil($total/$perPage),
                'items'=>$result

    
            ]);
    
           } catch (Exception $e){ 
     
            return response()->json(['error' => 'Une erreur est produite'], 500);
    
           
        }

       }
}
