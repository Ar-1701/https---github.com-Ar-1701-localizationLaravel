<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LocalizationController extends Controller
{
    public function index()
    {
        $langId = Session::get('langId');
        $data['lang'] = $this->language();
        $data['post'] = Post::whereRaw('language_id=?', $langId)->get();
        return view('show', $data);
    }
    // public function add_post(Request $req)
    // {
    //     $id = $req->id;
    //     $lang_id = $req->lang_id;
    //     $post_id = $req->post_id;
    //     $data['singleLang'] = Language::where(['id' => $lang_id])->get();
    //     // echo "<pre>";
    //     // print_r($data['singleLang']);
    //     $data['singleData'] = Post::find($id);
    //     $data['lang'] = Language::all();
    //     return view('add', $data);
    // }
    public function add_post(Request $req)
    {
        $id = $req->id;
        $lang_id = $req->lang_id;
        $post_id = $req->post_id;
        // echo "<pre>";
        // print_r($data['singleLang']);
        $data['singleData'] = Post::whereRaw('post_id=?', $post_id)->get();
        $data['lang'] = Language::all();
        return view('add', $data);
    }
    public function save_post(Request $req)
    {
        $id = $req->id;
        $lang_id = $req->locale;
        $title = $req->title;
        $post_cat = $req->post_cat;
        $post_desc = $req->post_desc;
        $u = Post::find($id);
        if ($req->hasFile('img')) {
            $image = $req->file('img');
            $imgName = time() . $image->getClientOriginalName();
            if (isset($u)) {
                File::delete(public_path('upload/post/' . $imgName));
                $image->move("public/upload/post", $imgName);
            }
        } else {
            $imgName = $req->old_img;
        }
        if (isset($u)) {
            foreach ($req->locale as $key => $l) {
                $id = $req->id[$key];
                $title = $req->title[$key];
                $post_cat = $req->post_cat[$key];
                $post_desc = $req->post_desc[$key];
                $i = Post::find($id);
                $i->post_title = $title;
                $i->post_cat = $post_cat;
                $i->post_desc = $post_desc;
                $i->post_img = $imgName;
                $i->save();
            }
            echo "update";
        } else {
            $post_id = "P" . rand(1111, 9999);
            foreach ($req->locale as $key => $l) {
                // $language = Language::whereIn('id', $req->locale)->get();
                // echo "<pre>";
                // print_r($language);
                // // die;
                $lang_id = $req->locale[$key];
                $title = $req->title[$key];
                $post_cat = $req->post_cat[$key];
                $post_desc = $req->post_desc[$key];
                $i = new Post();
                $i->post_id = $post_id;
                $i->language_id = $lang_id;
                $i->post_title = $title;
                $i->post_cat = $post_cat;
                $i->post_desc = $post_desc;
                $i->post_img = $imgName;
                $i->save();
            }
            $image->move("public/upload/post", $imgName);
            echo "save";
        }
    }
    // public function save_post(Request $req)
    // {
    //     // echo "<pre>";
    //     // print_r($req->all());
    //     // die;
    //     $id = $req->id;
    //     $lang_id = $req->locale;
    //     $title = $req->title;
    //     $post_cat = $req->post_cat;
    //     $post_desc = $req->post_desc;
    //     $u = Post::find($id);
    //     if ($req->hasFile('img')) {
    //         $image = $req->file('img');
    //         $imgName = time() . $image->getClientOriginalName();
    //         if (isset($u)) {
    //             File::delete(public_path('upload/post/' . $imgName));
    //             $image->move("public/upload/post", $imgName);
    //         }
    //     } else {
    //         $imgName = $req->old_img;
    //     }
    //     if (isset($u)) {
    //         $u->post_title = $title;
    //         $u->post_cat = $post_cat;
    //         $u->post_desc = $post_desc;
    //         $u->post_img = $imgName;
    //         $u->save();
    //         echo "update";
    //     } else {
    //         $post_id = "P" . rand(1111, 9999);
    //         foreach ($req->locale as $key => $l) {
    //             // $language = Language::whereIn('id', $req->locale)->get();
    //             // echo "<pre>";
    //             // print_r($language);
    //             // // die;
    //             $lang_id = $req->locale[$key];
    //             $title = $req->title[$key];
    //             $post_cat = $req->post_cat[$key];
    //             $post_desc = $req->post_desc[$key];
    //             $i = new Post();
    //             $i->post_id = $post_id;
    //             $i->language_id = $lang_id;
    //             $i->post_title = $title;
    //             $i->post_cat = $post_cat;
    //             $i->post_desc = $post_desc;
    //             $i->post_img = $imgName;
    //             $i->save();
    //         }
    //         $image->move("public/upload/post", $imgName);
    //         echo "save";
    //     }
    // }
    public function lang(Request $req)
    {
        $langId = $req->lang_id;
        $lang = Language::find($langId);
        App::setLocale($lang->lang);
        Session::put('langId', $langId);
        Session::put('lang', $lang->lang);
    }
    public function show_post(Post $post)
    {
        // echo "<pre>";
        // print_r($post->all());
        // echo "</pre>";
        $data['lang'] = $this->language();
        $data['post'] = $post->where('language_id', Session::get('langId'))->get();
        return view('showPost', $data);
    }
    public function language()
    {
        return Language::all();
    }
    public function posts(Post $post)
    {
        $data['lang'] = $this->language();
        $post = Post::whereRaw('language_id=?', Session::get('langId'))->get();
        $all_array = array();
        foreach ($post as $val) {
            $arr['id'] = $val->id;
            $arr['post_id'] = $val->post_id;
            $arr['language_id'] = $val->language_id;
            $arr['post_title'] = $val->post_title;
            $arr['post_cat'] = $val->post_cat;
            $arr['post_desc'] = $val->post_desc;
            $arr['post_img'] = $val->post_img;
            if (!in_array($arr['post_id'], array_column($all_array, 'post_id'))) {
                array_push($all_array, $arr);
            }
        }
        $data['post'] = $all_array;
        // echo "<pre>";
        // print_r($data['post']);
        // die;
        return view('post', $data);
    }
}
