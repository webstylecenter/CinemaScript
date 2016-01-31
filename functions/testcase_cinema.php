<?php

class Cinema
{

    /**
     * @var int
     */
    private $totalAmountOfSeats;

    /**
     * @var
     */
    private $seatList;

    /**
     * @var
     */
    private $visitors;

    /**
     * @var array
     */
    private $chosenSeats = [];

    /**
     * @var array
     */
    private $availableSeatsGroups = [];

    /**
     * Cinema constructor.
     * @param int $totalAmountOfSeats
     */
    public function __construct($totalAmountOfSeats = 18)
    {
        $this->totalAmountOfSeats = $totalAmountOfSeats;
        $this->createSeatList();
    }

    /**
     * Generates array with seat statuses
     */
    private function createSeatList()
    {
        for ($i = 0; $i < $this->totalAmountOfSeats; $i++) {
            if (rand(1, 4) == 1) {
                $this->seatList[$i] = 'taken';
                continue;
            }
            $this->seatList[$i] = 'free';
        }
    }

    /**
     * @param $visitors
     * @return array|string
     */
    function giveSeatNumbers($visitors)
    {
        $this->visitors = $visitors;

        if (!$this->visitorsCanBePlaced()) {
            return 'NULLIFY';
        }

        if(!$this->placeAllVisitorsInOneGroup()) {
            $this->sortSeatListByGroupSizeAndPosition();
            $this->placeVisitorsInBestAvailableGroups();
        };

        return $this->chosenSeats;
    }

    /**
     * @return bool
     */
    private function visitorsCanBePlaced()
    {
        $seatUsage = array_count_values($this->seatList);
        return ($seatUsage['free'] >= $this->visitors ? true : false);
    }


    /**
     * @return bool
     */
    private function placeAllVisitorsInOneGroup()
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
                if ($groupSize >= $this->visitors) {
                    $groupSize--;
                    $this->assignSeatToVisitor(($i-$groupSize), $this->visitors);
                    return true;
                }
            }
        }
        $this->availableSeatsGroups[($i-$groupSize)] = $groupSize;
        return false;
    }

    /**
     * Sorts by value, then seatList key
     */
    private function sortSeatListByGroupSizeAndPosition()
    {
        $temp = $this->availableSeatsGroups;
        uksort($this->availableSeatsGroups, function ($a,$b) use ($temp) {
            if ($temp[$a] === $temp[$b]) {
                return $a - $b;
            }
            return $temp[$b] - $temp[$a];
        });
    }

    private function placeVisitorsInBestAvailableGroups()
    {

        $queue = $this->visitors;
        while (list($key, $value) = each($this->availableSeatsGroups)) {
            $this->assignSeatToVisitor($key, $value);
            $queue = $queue - $value;
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
        $output = '';
        for ($i = 0; $i < $this->totalAmountOfSeats; $i++) {
            $output .= '<div class="seat ' . $this->seatList[$i] . '">'
                . ($i + 0) .
                '</div>';
        }
        return $output;
    }
}



