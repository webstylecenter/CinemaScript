<?php



class Cinema
{

    private $maxSeats;
    private $seats;
    private $visitors;
    public $chosenSeats = array();
    public $availableSeatsGroups = array();

    public $count = array(
        'x' => 0,
        'y' => 0,
        'z' => 0,
        'u' => 0,
        'f' => 0,
        'p' => 0,
        'r'=> 0,
        'fix'=>0
    );


    public function __construct($maxSeats = 18)
    {

        $this->maxSeats = $maxSeats;
        $this->createSeats();

    }

    function findAvailableSeatGroups()
    {
        $groupSize = 0;
        for ($i = 0; $i < $this->maxSeats; $i++) {
            if ($this->seats[$i] == 'taken') {
                if ($groupSize > 0) {
                    $this->availableSeatsGroups[($i-$groupSize)] = $groupSize;
                }
                $groupSize=0;
            } else {
                $groupSize++;
                if ($groupSize >= $this->visitors) {
                    $groupSize--;
                    $this->putInSeats(($i-$groupSize), $this->visitors);
                    echo 'Found at: '.($i-$groupSize);
                    return true;
                }
            }
        }
        $this->availableSeatsGroups[($i-$groupSize)] = $groupSize;
        print_r($this->availableSeatsGroups);
        return false;
    }

    public function sort()
    {
        $temp = $this->availableSeatsGroups;
        uksort($this->availableSeatsGroups, function ($a,$b) use ($temp) {
            if ($temp[$a] === $temp[$b]) {
                return $a - $b;
            }
            return $temp[$b] - $temp[$a];
        });
    }

    function giveSeatNumbers($visitors)
    {
        $this->visitors = $visitors;

        if (!$this->seatsAvailable()) {
            return 'NULLIFY';
        }

        if(!$this->findAvailableSeatGroups()) {
           // print_r($this->availableSeatsGroups);
            $this->sort();
            echo 'sorted:';
            print_r($this->availableSeatsGroups);
            $this->findBestPositions();
        };

        return array(
            'Chosen seats' => $this->chosenSeats
        );
    }

    public function createSeats()
    {
        for ($i = 0; $i < $this->maxSeats; $i++) { $this->count['z']++;
            if (rand(1, 4) == 1) {
                $this->seats[$i] = 'taken';
                continue;
            }
            $this->seats[$i] = 'free';
        }
    }

    public function seatsAvailable()
    {
       // TODO: Remove this at once!
        $seatUsage = array_count_values($this->seats);
        return ($seatUsage['free'] >= $this->visitors ? true : false);
    }

    public function findBestPositions()
    {

        $queue = $this->visitors;
        //echo 'Available:';
       // print_r($this->availableSeatsGroups);
        //echo 'start while';

        while (list($key, $value) = each($this->availableSeatsGroups)) {
            $this->putInSeats($key, $value);
           // print_r($this->chosenSeats);
            $queue = $queue - $value;
          //  echo 'que: '.$queue;
            if ($queue <= 0) {
                break;
            }
        }
      //  echo 'einde while';
    }

    public function putInSeats($start, $amount) {
        for ($i = 0; $i < $amount; $i++) {
            echo $this->seats[($start+$i)].' -> new <br />';
            $this->seats[($start+$i)] = 'new';
            array_push($this->chosenSeats, $start+$i);
        }

    }

    public function display()
    {
        $seatUsage = array_count_values($this->seats);
        $output = '';

        for ($i = 0; $i < $this->maxSeats; $i++) {
            $output .= '<div class="seat ' . $this->seats[$i] . '">'
                . ($i + 0) .
                '</div>';
        }
        return $output;
    }
}



