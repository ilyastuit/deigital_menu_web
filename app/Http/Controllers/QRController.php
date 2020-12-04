<?php

namespace App\Http\Controllers;
use App\Restorant;

use Illuminate\Http\Request;

class QRController extends Controller
{
    public function index(){
        $domain=env('APP_URL');
        $linkToTheMenu=$domain."/".env('URL_ROUTE','restaurant')."/".auth()->user()->restorant->subdomain;

        $dataToPass=[
            'url'=>$linkToTheMenu,
            'titleGenerator'=>__('Restaurant QR Generators'),
            'selectQRStyle'=>__('SELECT QR STYLE'),
            'selectQRColor'=>__('SELECT QR COLOR'),
            'color1'=>__('Color 1'),
            'color2'=>__('Color 2'),
            'titleDownload'=>__('QR Downloader'),
            'downloadJPG'=>__('Download JPG'),
            'titleTemplate'=>__('Menu Print template'),
            'downloadPrintTemplates'=>__('Download Print Templates'),
            'templates'=>explode(",",env('templates',"/impactfront/img/menu_template_1.jpg,/impactfront/img/menu_template_2.jpg")),
            'linkToTemplates'=>env('linkToTemplates',"/impactfront/img/templates.zip")
        ];

        return view('qrsaas.qrgen')->with('data', json_encode($dataToPass));
     }
}
