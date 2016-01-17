<?php



class Cinema
{

    private $maxSeats;
    private $seats;
    private $visitors;
    private $chosenSeats = array();

    public $count = array(
        'x' => 0,
        'y' => 0,
        'z' => 0,
        'u' => 0,
        'f' => 0,
        'p' => 0,
        'r'=> 0
    );


    public function __construct($maxSeats = 18)
    {

        $this->maxSeats = $maxSeats;
        $this->createSeats();
        $this->placeRandomPeople();
    }

    function giveSeatNumbers($visitors)
    {
        $this->visitors = $visitors;
        if (!$this->seatsAvailable()) {
            return 'NULLIFY';
        }
        $this->findBestPositions();

        return array(

            'Chosen seats' => $this->chosenSeats
        );
    }

    public function placeRandomPeople()
    {
        for ($i = 0; $i < $this->maxSeats; $i++) { $this->count['x']++;
            if (rand(1, 4) == 1) {
                $this->seats[$i] = 'taken';
            }
        }
    }

    public function createSeats()
    {
        for ($i = 0; $i < $this->maxSeats; $i++) { $this->count['z']++;
            $this->seats[$i] = 'free';
        }
    }

    public function seatsAvailable()
    {
        $seatUsage = array_count_values($this->seats);
        return ($seatUsage['free'] >= $this->visitors ? true : false);
    }

    public function placeVisitorsTogether($amount)
    {
        // TODO: $i++ oplossing vinden zodat het sneller werkt zonder fouten
        for ($i = 0; $i < $this->maxSeats; $i=$i+$amount) { $this->count['y']++;
            if ($this->isGroupEmpty($i, $amount)) {
                $this->populateGroup($i, $amount);
                return true;
            }
        }
        return false;
    }

    public function isGroupEmpty($startPosition, $amount)
    {
        for ($i = 0; $i < $amount; $i++) { $this->count['u']++;
            $pos = $startPosition + $i;
            if ($pos == $this->maxSeats) {
                return false;
            }
            if ($this->seats[$pos] == 'taken' || $this->seats[$pos] == 'new') {
                return false;
            }
        }
        return true;
    }

    public function populateGroup($startPosition, $amount)
    {
        for ($i = 0; $i < $amount; $i++) { $this->count['f']++;
            $pos = $startPosition + $i;
            $this->seats[$pos] = 'new';
            array_push($this->chosenSeats, $pos);
        }
    }

    public function findBestPositions()
    {
        $visitorQueue = $this->visitors;
        while ($visitorQueue > 0) { $this->count['r']++;
            for ($i = $visitorQueue; $i > 0; $i--) { $this->count['p']++;
                if ($this->placeVisitorsTogether($i)) {
                    $visitorQueue -= $i;
                    break;
                }
            }
        }
    }

    public function display()
    {
        $seatUsage = array_count_values($this->seats);
        $output = '';


       // $output .= '<p>Taken: '.$seatUsage['taken'].'<br />Available: '.$seatUsage['free'].'<br />Used: '.$seatUsage['new'].'</p>';
        for ($i = 0; $i < $this->maxSeats; $i++) {
            $output .= '<div class="seat ' . $this->seats[$i] . '">'
             . ($i + 1) .
            '</div>';
        }
        return $output;
    }

}


