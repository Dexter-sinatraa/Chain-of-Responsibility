<?php
// Об'єкт запиту
class Request {
    private $type;

    public function __construct($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }
}

// Абстрактний клас обробника
abstract class Handler {
    protected $successor;

    public function setSuccessor(Handler $successor) {
        $this->successor = $successor;
    }

    abstract public function handleRequest(Request $request);
}

// Конкретний обробник
class ConcreteHandlerA extends Handler {
    public function handleRequest(Request $request) {
        if ($request->getType() == 'TypeA') {
            echo "ConcreteHandlerA handles the request.<br>";
        } elseif ($this->successor) {
            $this->successor->handleRequest($request);
        }
    }
}

// Інший конкретний обробник
class ConcreteHandlerB extends Handler {
    public function handleRequest(Request $request) {
        if ($request->getType() == 'TypeB') {
            echo "ConcreteHandlerB handles the request.<br>";
        } elseif ($this->successor) {
            $this->successor->handleRequest($request);
        }
    }
}

// Використання паттерна Ланцюжок обов'язків
$handlerA = new ConcreteHandlerA();
$handlerB = new ConcreteHandlerB();

$handlerA->setSuccessor($handlerB);

$requestA = new Request('TypeA');
$requestB = new Request('TypeB');
$requestC = new Request('TypeC');

$handlerA->handleRequest($requestA); // ConcreteHandlerA handles the request.
$handlerA->handleRequest($requestB); // ConcreteHandlerB handles the request.
$handlerA->handleRequest($requestC); // (No handler can handle the request.)
