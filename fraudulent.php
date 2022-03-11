<?php

class Sort{

    public $queue = [];

    public function startQueue()
    {
        for ($i=0; $i < 201; $i++) { 
            $this->queue[$i] = 0;
        }
    }

    public function enqueue($number)
    {
        $this->queue[$number]++;
    }

    public function dequeue($number)
    {
        $this->queue[$number]--;
    }

    public function getMedian($d)
    {
        $even = false;
        $odd = false;
        $median = 0;
        $order = 0;
        $first = 0;
        $second = 0;
        if($d%2 == 0){
            $even = true;
            $order = [$d/2, $d/2+1];
        }else{
            $odd = true;
            $order = (int)($d/2+0.5);
        }
        
        $total = 0;
        foreach ($this->queue as $k => $v) {
            if($v != 0){
                $total = $total+$v;
                if(is_array($order)){
                    if($first == 0 && $total>=$order[0]){
                        $first = $k;
                    }
                    if($first != 0 && $second == 0 && $total>=$order[1]){
                        $second = $k;
                    }
                    if($first != 0 && $second != 0){
                        return ($first+$second)/2;
                    }
                }else{
                    if($total >= $order){
                        return $k;
                    }
                }
            }
        }
    }
}

function activityNotifications($exp, $d)
{
    $expCount = count($exp);
    $sort = new Sort();
    $notCount = 0;
    $sort->startQueue();

    for ($i=0; $i < $d; $i++) {
        $sort->enqueue($exp[$i]);
    }
    for ($i=$d; $i < $expCount; $i++) { 
        $median = $sort->getMedian($d);
        if($exp[$i] >= $median*2){
            $notCount++;
        }
        $sort->dequeue($exp[$i-$d]);
        $sort->enqueue($exp[$i]);
    }
    echo $notCount."\n";
    return $notCount;
}

$fptr = fopen("output-fraudulent.txt", "w");

$stdin = fopen("php://stdin", "r");

fscanf($stdin, "%[^\n]", $nd_temp);
$nd = explode(' ', $nd_temp);

$n = intval($nd[0]);

$d = intval($nd[1]);

fscanf($stdin, "%[^\n]", $expenditure_temp);

$expenditure = array_map('intval', preg_split('/ /', $expenditure_temp, -1, PREG_SPLIT_NO_EMPTY));

$result = activityNotifications($expenditure, $d);

fwrite($fptr, $result . "\n");

fclose($stdin);
fclose($fptr);