<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Mouvies;

class ChefController extends AbstractController
{
    /**
     * @Route("/chef", name="chef")
     */
    public function index()
    {
        return $this->render('chef/index.html.twig', [
            'controller_name' => 'ChefController',
        ]);
    }

    /**
     * @Route("/importJson", name="importJson", methods={"GET"})
     */
    public function testImportJson(){
        set_time_limit(300);
        $httpClient = HttpClient::create();
        for($i=200; $i<400; $i++){
            $response = $httpClient->request('GET', 'https://api.themoviedb.org/3/movie/popular?api_key=f691ea7d83712d42fdb6bacb8ae379f4&page='.$i);
            $statusCode = $response->getStatusCode();
            //echo $statusCode . "\n";

            $contentType = $response->getHeaders()['content-type'][0];
            //echo $contentType . "\n";

            $content = $response->getContent();
            
            foreach(json_decode($content)->results as $movie){
                //var_dump($movie);
                //echo "<br><br>";
                $normalizer = '';
                $movieObject = new Mouvies();
                $movieObject->setPopularity( $movie->popularity);
                $movieObject->setVoteCount($movie->vote_count);
                $movieObject->setVideo($movie->video);
                $movieObject->setPosterPath($movie->poster_path);
                $movieObject->setAdult($movie->adult);
                $movieObject->setBackdropPath($movie->backdrop_path);
                $movieObject->setOriginalLanguage($movie->original_language);
                $movieObject->setOriginalTitle($movie->original_title);
                $movieObject->setGenreIds($movie->genre_ids);
                $movieObject->setTitle($movie->title);
                $movieObject->setVoteAverage($movie->vote_average);
                $movieObject->setOverview($movie->overview);
                if (property_exists($movie, 'release_date')){ 
                    $movieObject->setReleaseDate($movie->release_date);
                }
                //var_dump($movieObject);
                /**/
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movieObject);
               
                /**/
            }
        }
        //j'ai fini avec mes modifs je remplie la bdd
        $entityManager->flush();
        //var_dump(json_decode($content['result']))sele;
        return $this->render('chef/index.html.twig', [
            'controller_name' => 'ChefController',
        ]);
    }
}
