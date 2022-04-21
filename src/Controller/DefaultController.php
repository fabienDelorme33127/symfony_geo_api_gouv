<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="list_regions", methods={"GET"})
     */
    public function listRegions(HttpClientInterface $client, SerializerInterface $serializer): Response
    {
        $response = $client->request('GET','https://geo.api.gouv.fr/regions', ['verify_peer' => false]); 
        $mesRegions = $response->getContent();

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('erreur');
        }else{
            
            $mesRegions = $serializer->decode($mesRegions, 'json');

            return $this->render('default/index.html.twig', [
                'mesRegions' => $mesRegions
            ]);
        }
    }
}
