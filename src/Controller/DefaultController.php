<?php

namespace App\Controller;

use App\Entity\Region;
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
        
            $mesRegionsObject = $serializer->deserialize($mesRegions, 'App\Entity\Region[]', 'json');

            return $this->render('default/index.html.twig', [
                'mesRegions' => $mesRegionsObject
            ]);
        }
    }


    /**
     * @Route("/listeDepsParRegion", name="listeDepsParRegion", methods={"GET"})
     */
    public function listeDepsParRegion(HttpClientInterface $client, SerializerInterface $serializer): Response
    {




        $response = $client->request('GET','https://geo.api.gouv.fr/regions', ['verify_peer' => false]); 
        $mesRegions = $response->getContent();

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('erreur');
        }else{
        
            $mesRegionsObject = $serializer->deserialize($mesRegions, 'App\Entity\Region[]', 'json');

            return $this->render('default/listeDepsParRegion.html.twig', [
                'mesRegions' => $mesRegionsObject
            ]);
        }
    }
}
