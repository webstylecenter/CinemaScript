<?php



class Cinema
{

    private $maxSeats;
    private $seats;
    private $visitors;
    private $chosenSeats = array();
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
        $this->countAvailableSeats();
        $this->placeRandomPeople();

    }

    function countAvailableSeats()
    {
        $this->availableSeatsGroups[] = [
            'min'=> 0,
            'max'=>$this->maxSeats-1,
            'size'=>$this->maxSeats-0
        ];
    }

    function updateAvailableSeatsGroup($start, $amount, $isVisitor)
    {

        // echo '<p>Start</p>';
        // print_r($this->availableSeatsGroups); echo '<br />';
        foreach ($this->availableSeatsGroups as $i => $group){ $this->count['fix']++;

            if ($group['min'] <= $start && $group['max'] >= $start) {

                unset($this->availableSeatsGroups[$i]);

                // Array ervoor
                if (($start - $group['min']) !== 0 && ($start-$amount > 0)) {
                    $this->availableSeatsGroups[] = [
                        'min'=> $group['min'],
                        'max'=> $start-$amount,
                        'size'=> ($start - $group['min'])
                    ];
                }

                // Plaats user
                if ($isVisitor) {
                    for ($x = 0; $x < $amount; $x++) {
                        //echo 'Oud: ('.($start+$x).'-'.$amount.') '.$this->seats[($start+$x)]. ' -> new<br />';
                        $this->seats[($start+$x)] = 'new';
                        $this->chosenSeats[] = ($start+$x)+1;
                    }
                } else {
                    $this->seats[$start] = 'taken';
                }

                // Array erna
                if (($group['max'] - ($start)) > 0) {
                    $this->availableSeatsGroups[] = [
                        'min'=> $start+$amount,
                        'max'=> $group['max'],
                        'size'=> ($group['max'] - ($start))
                    ];
                }
                //usort($this->availableSeatsGroups, 'sortBySize');
                //print_r($this->availableSeatsGroups); echo '<br />';
                return;
            }
        }


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
            if (rand(1, 2) == 1) {

                $this->updateAvailableSeatsGroup($i, 1, false);

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

        foreach ($this->availableSeatsGroups as $i => $group){
            if ($group['size'] >= $amount) { //echo 'Groote past ('.$amount.') ';
                $this->updateAvailableSeatsGroup($group['min'], $amount, true);
                return true;
            }
        }
        return false;

    }

    public function findBestPositions()
    {

        $visitorQueue = $this->visitors;
        while ($visitorQueue > 0) { $this->count['r']++;
            for ($i = $visitorQueue; $i > 0; $i--) { $this->count['p']++;
                if ($this->placeVisitorsTogether($i)) {
                    // echo '<p>vis'.$visitorQueue.'  - '.$i.'</p>';
                    $visitorQueue -= $i;
                    $i = $visitorQueue;
                }
            }
        }
    }

    public function display()
    {
        $seatUsage = array_count_values($this->seats);
        $output = '';

        for ($i = 0; $i < $this->maxSeats; $i++) {
            $output .= '<div class="seat ' . $this->seats[$i] . '">'
                . ($i + 1) .
                '</div>';
        }
        return $output;
    }

}

function sortBySize($x, $y)
{
    if ($x == $y) {
        return 0;
    } else {
        return $x['min'] - $y['min'];
    }
}



