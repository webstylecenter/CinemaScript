<?php

class Cinema
{

    /**
     * @var int
     */
    private $totalAmountOfSeats;

    /**
     * @var array
     */
    private $seatList;

    /**
     * @var array
     */
    public $chosenSeats = [];

    /**
     * @var array
     */
    private $availableSeatsGroups = [];

    /**
     * Cinema constructor.
     * @param int $totalAmountOfSeats
     */
    public function __construct($totalAmountOfSeats = 18, $predefinedTakenSeats = NULL)
    {
        $this->totalAmountOfSeats = $totalAmountOfSeats;
        $this->createSeatList($predefinedTakenSeats);
    }

    /**
     * Generates array with seat statuses
     */
    private function createSeatList($predefinedTakenSeats)
    {
        if (is_array($predefinedTakenSeats)) {
            for ($i = 0; $i < $this->totalAmountOfSeats; $i++) {
                if (isset($predefinedTakenSeats[$i])) {
                    $this->seatList[$i] = 'taken';
                    continue;
                }
                $this->seatList[$i] = 'free';
            }
        } else {
            for ($i = 0; $i < $this->totalAmountOfSeats; $i++) {
                if (rand(1, 4) == 1) {
                    $this->seatList[$i] = 'taken';
                    continue;
                }
                $this->seatList[$i] = 'free';
            }
        }

    }

    /**
     * @param $visitors
     * @return array|string
     */
    public function giveSeatNumbers($visitors)
    {
        if (!$this->canAllocate($visitors)) {
            return 'NULLIFY';
        }

        if(!$this->placeAllVisitorsInOneGroup($visitors)) {
            $this->sortByValueAndKey($this->availableSeatsGroups);
            $this->placeVisitorsInBestAvailableGroups($visitors);
        };

        return $this->chosenSeats;
    }

    /**
     * @return bool
     */
    private function canAllocate($visitors)
    {
        $seatUsage = array_count_values($this->seatList);
        return ($seatUsage['free'] >= $visitors ? true : false);
    }


    /**
     * @return bool
     */
    private function placeAllVisitorsInOneGroup($visitors)
    {
        $groupSize = 0;
        for ($i = 0; $i < $this->totalAmountOfSeats; $i++) {
            if ($this->seatList[$i] == 'taken') {
                if ($groupSize > 0) {
                    $this->availableSeatsGroups[($i-$groupSize)] = $groupSize;
                }
                $groupSize=0;
            } else {
                $groupSize++;
                if ($groupSize >= $visitors) {
                    $groupSize--;
                    $this->assignSeatToVisitor(($i-$groupSize), $visitors);
                    return true;
                }
            }
        }
        $this->availableSeatsGroups[($i-$groupSize)] = $groupSize;
        return false;
    }

    /**
     * Sorts by value, followed by its key
     */
    public function sortByValueAndKey($array)
    {
        $temp = $array;
        uksort($this->availableSeatsGroups, function ($a,$b) use ($temp) {
            if ($temp[$a] === $temp[$b]) {
                return $a - $b;
            }
            return $temp[$b] - $temp[$a];
        });
    }

    private function placeVisitorsInBestAvailableGroups($visitors)
    {

        $queue = $visitors;
        while (true) {

            $bestKey = $bestValue = $groupAmount = NULL;

            foreach ($this->availableSeatsGroups as $key => $value) {
                $amount = ($value > $queue ? $queue : $value);
                if ($amount <= $value) {
                    if ($bestKey === NULL) {
                        $bestKey = $key;
                        $bestValue = $value;
                        $groupAmount = $amount;
                    } elseif ($key <= $bestKey && $value >= $queue) {
                        $bestKey = $key;
                        $bestValue = $value;
                        $groupAmount = $amount;
                    } else {
                    }
                }
            }

            $this->assignSeatToVisitor($bestKey, $groupAmount);
            $queue = $queue - $groupAmount;
            unset($this->availableSeatsGroups[$bestKey]);

            if ($queue <= 0) {
                break;
            }
        }
    }

    /**
     * @param int $start
     * @param int $amount
     */
    private function assignSeatToVisitor($start, $amount) {
        for ($i = 0; $i < $amount; $i++) {
            $this->seatList[($start+$i)] = 'new';
            array_push($this->chosenSeats, $start+$i);
        }
    }

    /**
     * @return string
     */
    public function showSeats()
    {
        for ($i = 0; $i < $this->totalAmountOfSeats; $i++) {
            echo '<div class="seat ' . $this->seatList[$i] . '">'
                . ($i + 1) .
                '</div>';
        }
    }
}
