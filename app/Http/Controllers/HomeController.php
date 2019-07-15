<?php

namespace App\Http\Controllers;
use DB;
use DateTime;
use Illuminate\Http\Request;
use App\Cr;

/**
 *  Controller da página Home
 *  Listagem de férias e licenças que inicializar nos próximos 15 dias; Listagem de férias e licenças que finalizam nos próximos 15 dias.
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
