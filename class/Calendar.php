<?php



class Calendar{

    private $_day,
            $_indexDay,
            $_month,
            $_year,
            $_numDays,
            $_numDaysPrev,
            $_fullMonth,
            $_fullDay;


    public function __construct($month = null, $year = null, $day = null){

        if($month == null && $year == null){
            $this->_day = date('j');
            $this->_indexDay = date('N');
            $this->_fullDay = date('D');
            $this->_month = date ('n');
            $this->_fullMonth = date ('F');
            $this->_year = date ('Y');
            $this->_numDays = date('t');
            $this->_numDaysPrev = date('t', mktime(0, 0,0, date('n')-1));
        }else{
            $this->_day = date('j', mktime(0, 0, 0, $month, $day, $year));
            $this->_indexDay = date('N', mktime(0, 0, 0, $month, $day, $year));
            $this->_fullDay = date('D', mktime(0, 0, 0, $month, $day, $year));
            $this->_month = $month;
            $this->_fullMonth = date ('F', mktime(0, 0, 0, $month));
            $this->_year = $year;
            $this->_numDays = date('t', mktime(0, 0, 0, $month));
            $this->_numDaysPrev = date('t', mktime(0, 0,0, date('n', mktime(0, 0, 0, $month, 0, $year))));
        }
    }


    public function getFirstDay($month, $year){
        return date('N', mktime(0,0,0, $month,1, $year));
}




    public function allDays(){

        $days = array();

        $k= $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1 ;

        for ($i=1 ; $i<= $this->getFirstDay($this->_month, $this->_year); $i++){
            $days[$i]= $k ;
            $k++ ;
        }

        $k = 1;

        for ($i= $this->getFirstDay($this->_month, $this->_year) +1 ; $i<= $this->_numDays + $this->getFirstDay($this->_month, $this->_year); $i++){
            $days [$i]= $k ;
            $k++;
        }

        $k = 1;

        for ($i= $this->_numDays + $this->getFirstDay($this->_month, $this->_year)+1 ; $i<= 42 ; $i++){
            $days [$i]= $k;
            $k++;

        }

        return $days ;
    }

    public function getWeek($lastDay = null){

        if($lastDay == null){
            $week = array();

            switch ($this->_indexDay){

                case 7:
                    $k = 0;
                    $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                    $nextDays = 1;

                    for($i = $this->_day; $i <= $this->_day+6; $i++){
                        if($i < 1){
                            $week[$k]['day'] = $prevDays;
                            $week[$k]['month'] = $this->_month-1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $prevDays++;
                        }elseif ($i > $this->_numDays){
                            $week[$k]['day'] = $nextDays;
                            $week[$k]['month'] = $this->_month+1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $nextDays++;
                        }else{
                            $week[$k]['day'] = $i;
                            $week[$k]['month'] = $this->_month;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                        }
                    }
                    break;

                case 1:
                    $k = 0;
                    $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                    $nextDays = 1;

                    for($i = $this->_day-1; $i <= $this->_day+5; $i++){
                        if($i < 1){
                            $week[$k]['day'] = $prevDays;
                            $week[$k]['month'] = $this->_month-1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $prevDays++;
                        }elseif ($i > $this->_numDays){
                            $week[$k]['day'] = $nextDays;
                            $week[$k]['month'] = $this->_month+1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $nextDays++;
                        }else{
                            $week[$k]['day'] = $i;
                            $week[$k]['month'] = $this->_month;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                        }
                    }
                    break;

                case 2:
                    $k = 0;
                    $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                    $nextDays = 1;

                    for($i = $this->_day-2; $i <= $this->_day+4; $i++){
                        if($i < 1){
                            $week[$k]['day'] = $prevDays;
                            $week[$k]['month'] = $this->_month-1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $prevDays++;
                        }elseif ($i > $this->_numDays){
                            $week[$k]['day'] = $nextDays;
                            $week[$k]['month'] = $this->_month+1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $nextDays++;
                        }else{
                            $week[$k]['day'] = $i;
                            $week[$k]['month'] = $this->_month;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                        }
                    }
                    break;

                case 3:
                    $k = 0;
                    $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                    $nextDays = 1;

                    for($i = $this->_day-3; $i <= $this->_day+3; $i++){
                        if($i < 1){
                            $week[$k]['day'] = $prevDays;
                            $week[$k]['month'] = $this->_month-1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $prevDays++;
                        }elseif ($i > $this->_numDays){
                            $week[$k]['day'] = $nextDays;
                            $week[$k]['month'] = $this->_month+1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $nextDays++;
                        }else{
                            $week[$k]['day'] = $i;
                            $week[$k]['month'] = $this->_month;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                        }
                    }
                    break;

                case 4:
                    $k = 0;
                    $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                    $nextDays = 1;

                    for($i = $this->_day-4; $i <= $this->_day+2; $i++){
                        if($i < 1){
                            $week[$k]['day'] = $prevDays;
                            $week[$k]['month'] = $this->_month-1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $prevDays++;
                        }elseif ($i > $this->_numDays){
                            $week[$k]['day'] = $nextDays;
                            $week[$k]['month'] = $this->_month+1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $nextDays++;
                        }else{
                            $week[$k]['day'] = $i;
                            $week[$k]['month'] = $this->_month;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                        }
                    }
                    break;

                case 5:
                    $k = 0;
                    $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                    $nextDays = 1;

                    for($i = $this->_day-5; $i <= $this->_day+1; $i++){
                        if($i < 1){
                            $week[$k]['day'] = $prevDays;
                            $week[$k]['month'] = $this->_month-1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $prevDays++;
                        }elseif ($i > $this->_numDays){
                            $week[$k]['day'] = $nextDays;
                            $week[$k]['month'] = $this->_month+1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $nextDays++;
                        }else{
                            $week[$k]['day'] = $i;
                            $week[$k]['month'] = $this->_month;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                        }
                    }
                    break;

                case 6:
                    $k = 0;
                    $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                    $nextDays = 1;

                    for($i = $this->_day-6; $i <= $this->_day; $i++){
                        if($i < 1){
                            $week[$k]['day'] = $prevDays;
                            $week[$k]['month'] = $this->_month-1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $prevDays++;
                        }elseif ($i > $this->_numDays){
                            $week[$k]['day'] = $nextDays;
                            $week[$k]['month'] = $this->_month+1;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                            $nextDays++;
                        }else{
                            $week[$k]['day'] = $i;
                            $week[$k]['month'] = $this->_month;
                            $week[$k]['year'] = $this->_year;
                            $k++;
                        }
                    }
                    break;
            }

            return $week;
        }else{

            $week = array();


                $k = 0;
                $prevDays = $this->_numDaysPrev - $this->getFirstDay($this->_month, $this->_year) + 1;
                $nextDays = 1;

                for($i = $lastDay - 6; $i <= $lastDay; $i++){
                    if($i < 1){
                        $week[$k]['day'] = $prevDays;
                        $week[$k]['month'] = $this->_month-1;
                        $week[$k]['year'] = $this->_year;
                        $k++;
                        $prevDays++;
                    }elseif ($i > $this->_numDays){
                        $week[$k]['day'] = $nextDays;
                        $week[$k]['month'] = $this->_month+1;
                        $week[$k]['year'] = $this->_year;
                        $k++;
                        $nextDays++;
                    }else{
                        $week[$k]['day'] = $i;
                        $week[$k]['month'] = $this->_month;
                        $week[$k]['year'] = $this->_year;
                        $k++;
                    }
                }
            }
            return $week;
    }

    public function getNextMonthFromWeek($lastDay = null){
        if($lastDay + 7 > $this->_numDays || $lastDay + 7 == 7){
            if($this->_month == 12){
                return 1;
            }
            return $this->_month + 1;
        }
        return $this->_month;
    }

    public function getPrevMonthFromWeek($lastDay = null){
        if($lastDay == null){
            return $this->_month;
        }else{
            if($lastDay - 7 < 1){
                if($this->_month == 1){
                    return 12;
                }
                return $this->_month - 1;
            }
            return $this->_month;
        }
    }

    public function getNextYearFromDay(){
        if($this->_month == 12 && $this->_day == $this->_numDays){
            return $this->_year + 1;
        }
        return $this->_year;
    }

    public function getPrevYearFromDay(){
        if($this->_month == 1 && $this->_day == 1){
            return $this->_year - 1;
        }
        return $this->_year;
    }

    public function getNextYearFromWeek($lastDay = null){
        if($this->_month == 12 && $lastDay > $this->_numDays - 7){
            return $this->_year + 1;
        }
        return $this->_year;
    }

    public function getPrevYearFromWeek($lastDay = null){
        if($this->_month == 1 && $lastDay - 7 < 1){
            return $this->_year - 1;
        }
        return $this->_year;
    }

    public function getNextWeek($lastDay = null){

        $lastDay = $this->getWeek($lastDay);
        $lastDay = end($lastDay);

        if($lastDay['day'] + 7 > $this->_numDays){
            return $lastDay['day'] + 7 - $this->_numDays;
        }

        return $lastDay['day'] + 7;
    }

    public function getPrevWeek($lastDay = null){

        $lastDay = $this->getWeek($lastDay);
        $lastDay = end($lastDay);

        if($lastDay['day'] - 7 < 1){
            return $this->_numDaysPrev + $lastDay['day'] - 7;
        }

        return $lastDay['day'] - 7;

    }



    public function getPrevDay(){
        if($this->_day == 1){
            return $this->_numDaysPrev;
        }
        return $this->_day - 1;
    }

    public function getNextDay(){
        if ($this->_day == $this->_numDays){
            return 1;
        }
        return $this->_day + 1;
    }


    public function getPrevMonth($day = null){
        if($day == null){
            if($this->_month == 1){
                return 12;
            }
            return $this->_month - 1;
        }else{
            if($day == 1){
                if($this->_month == 1){
                    return 12;
                }else{
                    return $this->_month - 1;
                }
            }
            return $this->_month;
        }
    }

    public function getNextMonth($day = null){
        if($day == null){
            if($this->_month == 12){
                return 1;
            }
            return $this->_month + 1;
        }else{
            if($day == $this->_numDays){
                if($this->_month == 12){
                    return 1;
                }else{
                    return $this->_month + 1;
                }
            }
            return $this->_month;
        }



    }

    public function getPrevYear(){
        if($this->_month == 1){
            return $this->_year-1;
        }
        return $this->_year;
    }

    public function getNextYear(){
        if($this->_month == 12){
            return $this->_year+1;
        }
        return $this->_year;
    }

    public function getDay()
    {
        return $this->_day;
    }

    public function getMonth()
    {
        return $this->_month;
    }

    public function getNumDays()
    {
        return $this->_numDays;
    }

    public function getYear()
    {
        return $this->_year;
    }

    public function getFullMonth()
    {
        return $this->_fullMonth;
    }

    public function getFullDay()
    {
        return $this->_fullDay;
    }

    public function getNumDaysPrev()
    {
        return $this->_numDaysPrev;
    }

    public function setMonth($month)
    {
        $this->_month = $month;
    }

    /* Google methods */

    public function eventStartTime($dateTime){
        $dateTime = substr($dateTime, 11, 5);
        return $dateTime;
    }

    public function eventEndTime($dateTime){
        $dateTime = substr($dateTime, 11, 5);
        return $dateTime;
    }

}