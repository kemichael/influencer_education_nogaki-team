<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Banner;
class TopController extends Controller
{
    public function showTop() {
        $model = new Article();
        $articles = $model->getList(); 
        $model = new Banner();
        $banners = $model->getList(); 
        return view('top',['articles' => $articles,'banners' => $banners]);
    }
     public function showCurriculum_list() {
        // $model = new Article();
        // $articles = $model->getList(); 
        // return view('curriculum_list',['articles' => $articles]);
        return view('curriculum_list');
    }
     public function showCurriculum_progress() {
        // $model = new Banner();
        // $banners = $model->getList(); 
        // return view('curriculum_progress',['articles' => $articles]);
        return view('curriculum_progress');
    }
}
