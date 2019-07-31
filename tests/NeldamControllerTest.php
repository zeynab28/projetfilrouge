<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NeldamControllerTest extends WebTestCase
{
    public function testajout()
    {
        $client = static::createClient([],[

                    'PHP_AUTH_USER' => 'guisszo',
                    'PHP_AUTH_PW' => 'pass',
        
             ]);
        $crawler = $client->request('POST', '/api/ajout',[],[],['CONTENT_TYPE'=>"application/json"],
        '{"id": 1,"RaisonSociale": "sarl","ninea": 1120025,"adresse": "aroser","phone": 77788784,"email": "zweejhd@gmail.com","utilisateur": 1,"depots":1200000,"numbcompt": 00125589751,"statut": "actif"}');
        $rep=$client->getResponse();    
        

        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
}
