<?php

namespace Urcalanda\Control;

class RegExprQueueTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RegExprQueue
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new RegExprQueue;

    }

    protected function setUpDefaultRegExpr(){
        $regExpr1 = new RegExpr();
        $regExpr1->setRegExpr('/java/i');
        $regExpr1->setPriority(3);
        $regExpr1->setCommand(new Command('Comando de Java'));
        $this->object->addByPriority($regExpr1);
        $regExpr2 = new RegExpr();
        $regExpr2->setRegExpr('/php/i');
        $regExpr2->setPriority(5);
        $regExpr2->setCommand(new Command('Comando de PHP'));
        $this->object->addByPriority($regExpr2);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    public function testEmptyQueue(){
        $listOfCommands = $this->object->getCommandsBySubjectOrderByPriorityDesc('');
        $this->assertEquals(array(),$listOfCommands);
    }

    public function testRegExprDoesntMatch(){

        $this->setUpDefaultRegExpr();

        $listOfCommands = $this->object
                            ->getCommandsBySubjectOrderByPriorityDesc('Programamos en Python');
        $this->assertEquals(array(),$listOfCommands);
    }

    public function testSamePrioritySameRegExpr(){
        $regExpr1 = new RegExpr();
        $regExpr1->setRegExpr('/java/i');
        $regExpr1->setPriority(3);
        $regExpr1->setCommand(new Command('Comando de Java 1'));
        $this->object->addByPriority($regExpr1);
        $regExpr2 = new RegExpr();
        $regExpr2->setRegExpr('/java/i');
        $regExpr2->setPriority(3);
        $regExpr2->setCommand(new Command('Comando de Java 2'));
        $this->object->addByPriority($regExpr2);

        $listOfCommands = $this->object
                            ->getCommandsBySubjectOrderByPriorityDesc('Programamos en Java');
        $this->assertEquals(2,count($listOfCommands));
        $this->assertEquals('Comando de Java 1',$listOfCommands[0]->getName());
        $this->assertEquals('Comando de Java 2',$listOfCommands[1]->getName());
    }

    public function testSamePriorityDistinctRegExpr(){
        $regExpr1 = new RegExpr();
        $regExpr1->setRegExpr('/java/i');
        $regExpr1->setPriority(3);
        $regExpr1->setCommand(new Command('Comando de Java'));
        $this->object->addByPriority($regExpr1);
        $regExpr2 = new RegExpr();
        $regExpr2->setRegExpr('/php/i');
        $regExpr2->setPriority(3);
        $regExpr2->setCommand(new Command('Comando de PHP'));
        $this->object->addByPriority($regExpr2);

        $listOfCommands = $this->object
                            ->getCommandsBySubjectOrderByPriorityDesc('Programamos en Java');
        $this->assertEquals(1,count($listOfCommands));
        $this->assertEquals('Comando de Java',$listOfCommands[0]->getName());
    }

    public function testDistinctPrioritySameRegExpr(){
        $regExpr1 = new RegExpr();
        $regExpr1->setRegExpr('/java/i');
        $regExpr1->setPriority(3);
        $regExpr1->setCommand(new Command('Comando de Java 3.1'));
        $this->object->addByPriority($regExpr1);
        $regExpr2 = new RegExpr();
        $regExpr2->setRegExpr('/java/i');
        $regExpr2->setPriority(5);
        $regExpr2->setCommand(new Command('Comando de Java 5.1'));
        $this->object->addByPriority($regExpr2);
        $regExpr3 = new RegExpr();
        $regExpr3->setRegExpr('/java/i');
        $regExpr3->setPriority(3);
        $regExpr3->setCommand(new Command('Comando de Java 3.2'));
        $this->object->addByPriority($regExpr3);
        $regExpr4 = new RegExpr();
        $regExpr4->setRegExpr('/java/i');
        $regExpr4->setPriority(4);
        $regExpr4->setCommand(new Command('Comando de Java 4.1'));
        $this->object->addByPriority($regExpr4);

        $listOfCommands = $this->object
                            ->getCommandsBySubjectOrderByPriorityDesc('Programamos en Java');

        $this->assertEquals(4,count($listOfCommands));
        $this->assertEquals('Comando de Java 5.1',$listOfCommands[0]->getName());
        $this->assertEquals('Comando de Java 4.1',$listOfCommands[1]->getName());
        $this->assertEquals('Comando de Java 3.1',$listOfCommands[2]->getName());
        $this->assertEquals('Comando de Java 3.2',$listOfCommands[3]->getName());
    }


    public function testDiferentCommands(){
        $this->setUpDefaultRegExpr();

        $listOfCommandsOfJava = $this->object
                            ->getCommandsBySubjectOrderByPriorityDesc('Programamos en Java');
        $listOfCommandsOfPHP = $this->object
                            ->getCommandsBySubjectOrderByPriorityDesc('Programamos en PHP');

        $this->assertEquals(1,count($listOfCommandsOfJava));
        $this->assertEquals('Comando de Java',$listOfCommandsOfJava[0]->getName());
        $this->assertEquals(1,count($listOfCommandsOfPHP));
        $this->assertEquals('Comando de PHP',$listOfCommandsOfPHP[0]->getName());
    }

}
