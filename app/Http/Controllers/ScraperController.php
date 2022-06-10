<?php

namespace App\Http\Controllers;

use Exception;
use Goutte\Client;

use Symfony\Component\HttpClient\HttpClient;

class ScraperController extends Controller
{
    private $results = array();

    public function index()
    {
        //class="wpgb-block-2 wpgb-idle-scheme-1"
        $client = new Client(HttpClient::create(["verify_peer" => false, "verify_host" => false]));
        $url = "https://www.lafrenchfab.fr/communaute/?_filtrer_par_taille=pme";
        $page = $client->request("GET", $url);
        //
        $page->filter(".wpgb-card-body")->each(function($item){
            $this->results[] = [
                    "nom" => $item->filter(".wpgb-block-1")->text(),
                    "groupe" => $item->filter(".wpgb-block-2")->text(),
                    "mail" => $item->filter(".wpgb-block-3")->text()
                ];
        //    
        });
        ////&_chargement_des_pages=1955
        for($i = 1; $i < 1956; $i++)
        {
            $url = "https://www.lafrenchfab.fr/communaute/?_filtrer_par_taille=pme&_chargement_des_pages=".$i;
            try{
                $page = $client->request("GET", $url);
                $page->filter(".wpgb-card-body")->each(function($item){
                    $this->results[] = [
                        "nom" => $item->filter(".wpgb-block-1")->text(),
                        "groupe" => $item->filter(".wpgb-block-2")->text(),
                        "mail" => $item->filter(".wpgb-block-3")->text()
                    ];
                
                });
            }catch(Exception $e)
            {
//
            }
        //    
//
        }
        
        echo "<pre>";
        print_r($this->results);
        die();
        //return view("scraper");
    }
}
