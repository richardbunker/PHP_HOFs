<?php 

class Collection {
    private $collect = [];

    public function __construct($args = []) {
        $this->collect = $args;
    }

    public function filter($callback)
    {
        $filtered = [];
        for ($i=0; $i < count($this->collect) ; $i++) { 
            if ($callback($this->collect[$i], $i)) {
                $filtered[] = $this->collect[$i];
            }
        }
        return new static($filtered);
    }

    public function map($callback)
    {
        $mapped = [];
        for ($i=0; $i < count($this->collect) ; $i++) {
            $mapped[] = $callback($this->collect[$i], $i);
        }
        return new static($mapped);
    }

    public function reduce($callback, $acc)
    {
        $reduced = $acc;
        foreach ($this->collect as $value) {
            $reduced = $callback($reduced, $value);
        } 
        return new static([$reduced]);
    }

    public function values()
    {
        return json_encode(array_values($this->collect));
    }

    public function keys()
    {
        return json_encode(array_keys($this->collect));
    }

    public function sum() {
        return $this->reduce(function($acc, $item){
            return $acc + $item;
        }, 0)->values();
    }
}

?>

<pre>
    <?php
        $collect = new Collection([1,2,8,7,8,9,78]);
        echo $collect->sum();
    ?>
</pre>