<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author hosha
 */
class FormationRepositoryTest extends KernelTestCase {
    //put your code here
    public function recupRepository():FormationRepository{
        self::bootKernel();
        $repository=self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    public function testNbFormations(){
        $repository=$this->recupRepository();
        $nbFormations=$repository->count([]);
        $this->assertEquals(127, $nbFormations);
    }
    
    public function newFormation():Formation{
        $formation=(new Formation())
                ->setTitle('Test')
                ->setDescription('test description')
                ->setVideoId('pdjiuhdy')
                ->setPublishedAt(new DateTime("now"));
        return $formation;
    }
    
    public function testAddFormation(){
        $repository=$this->recupRepository();
        $formation=$this->newFormation();
        $nbFormations=$repository->count([]);
        $repository->add($formation,true);
        $this->assertEquals($nbFormations+1,$repository->count([]),"erreur");
    }
    
    public function testRemoveFormation(){
        $repository=$this->recupRepository();
        $formation=$this->newFormation();
        $repository->add($formation, true);
        $nbFormations=$repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations-1,$repository->count([]),"erreur");
    }
    
    
        public function testFindByEqualValue(){
        $repository=$this->recupRepository();
        $formation=$this->newFormation();
        $repository->add($formation, true);
        $formations=$repository->findByEqualValue("Title","Test");
        $nbFormations=count($formations);
        $this->assertEquals(1,$nbFormations);
        $this->assertEquals("Test",$formations[0]->getTitle());
        }
}
