<?php
namespace MyCompanyShop {

    use SplObserver;
    use SplSubject;

    class Product implements SplSubject
    {
        private $data = [];
        private $observers = [];

        public function __get($key)
        {
            return $this->data[$key];
        }

        public function __set($key, $value)
        {
            $this->data[$key] = $value;
            $this->notify();
        }

        public function attach(SplObserver $observer)
        {
            $this->observers[] = $observer;
        }

        public function detach(SplObserver $observer)
        {
            $this->observers = array_filter($this->observers, function($obs) use ($observer) { return $obs !== $observer; });
        }

        public function notify()
        {
            foreach ($this->observers as $observer) {
                $observer->update($this);
            }
        }


    }

    class Logger implements SplObserver
    {
        private $events = [];

        public function getEvents()
        {
            return $this->events;
        }

         function update(SplSubject $subject)
        {
            $this->events[] = $subject;
        }


    }
}

namespace {
    use MyCompanyShop\Product,
        MyCompanyShop\Logger;

    $p = new Product;
    $l = new Logger;
    $p->name = 'Test Product 1';
    $p->attach($l);

    assert(count($l->getEvents()) == 0);
    $p->foo = 'bar';
    assert(count($l->getEvents()) == 1);

}
