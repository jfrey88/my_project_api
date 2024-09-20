<?php

namespace App\Controller;

use App\Service\OmdbApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    private $omdbApiService;

    public function __contruct(OmdbApiService $omdbApiService)
    {
        $this->omdbApiService = $omdbApiService;
    }

    #[Route(path :'/movies', name: 'movies_search')]
    public function search(Request $request) : Response
    {
        $title = $request->query->get(key: 'title');
        $movies = [];
        dump($this->omdbApiService);
        if ($title){
            try{
                $movies = $this->omdbApiService->searchMovies($title);
            } catch (\Exception $e){
                $this->addFlash(type: 'error', message: $e->getMessage());
            }

                
        }
        return $this->render(view: 'movies/search.html.twig',parameters:[
            'movies' => $movies,
            'title' => $title
        ]);
    }




    #[Route('/movie', name: 'app_movie')]
    public function index(): Response
    {
        return $this->render('movies/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }
}
