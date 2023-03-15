<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationsControllerTest
 *
 * @author hosha
 */
class FormationsControllerTest extends WebTestCase {
    //put your code here
    
    public function testAccesPage(){
        $client=static::createClient();
        $client->request('GET','/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testFiltreTitre(){
        $client = static::createClient();
        $client->request('GET','/formations');
        $crawler=$client->submitForm('filtrer',[
            'recherche'=>'cours'
        ]);
        $this->assertCount(1,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5','cours');
    }
    
    public function testeLinkFormations(){
        $client = static::createClient();
        $client->request('GET','/index.php');
        $client->clickLink('Formations');
        $response=$client->getResponse();
        $this->assertEquals(Response::HTTP_OK,$response->getStatusCode());
        $uri=$client->getRequest()->server->get("REQUEST_URI");
        $this->assertsEquals("/formations",$uri);
    }
}
