<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
class AdminController extends Controller
{
    public  function index(){
        if(view()->exists('admin.index')){
            return view('admin.index');
        }
    }
    public  function login(){
        if(view()->exists('admin.login')){
            return view('admin.login');
        }
    }
}