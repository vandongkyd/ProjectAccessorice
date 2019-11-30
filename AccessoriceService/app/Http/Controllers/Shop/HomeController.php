<?php


namespace App\Http\Controllers\Shop;


use App\Http\Controllers\Controller;
use App\Service\Shop\HomeService;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(){

        $banners = $this->homeService->banners();

        $brands = $this->homeService->brands();

        return view('shop.home',compact('banners','brands'));
    }
}