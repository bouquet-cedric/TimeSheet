<?php

    require_once(__DIR__."/template.php");

    class TimesTest extends ClassTest{

        public function testTimes(){
            $this->assert(True,Times::$days["Monday"] == "Lundi");
            $this->assert(True,Times::$months[0] == "Janvier");
        }

        public function testBissextile(){
            for ($i=2000;$i<2030;$i+=4){
                $this->assert(True,Times::bissextile($i));
            }
            $this->assert(False,Times::bissextile(1900));
            try {
                Times::bissextile("102");
            }
            catch(Exception $e){
                $this->assert(BISSEXTILE_EXCEPT,$e->getMessage());
            }
        }

        public function testSplit(){
            $this->assert(5104,Times::splitTime("10d 5h 4"));
            $this->assert(480,Times::splitTime("1d"));
            $this->assert(780,Times::splitTime("1d 5h"));
            $this->assert(300,Times::splitTime("5h"));
            $this->assert(5,Times::splitTime("5"));
        }

        public function testFormat(){
            $this->assert("Dimanche 03 Juillet 2022", Times::getFormat("Sunday 03-07-2022"));
            $this->not_assert("Dimanche 3 Juillet 2022", Times::getFormat("Sunday 03-07-2022"));
            $this->not_assert("Lundi 4 juillet 2022", Times::getFormat("Monday 04-07-2022"));
        }

        public function testRealTime(){
            $tests=[4800,480,180,300,920,120,160];
            $expected=["10 jours","1 jour","3 heures","5 heures","1 jour 7 heures 20 minutes","2 heures","2 heures 40 minutes"];
            for($i=0;$i<count($tests);$i++){
                $this->assert($expected[$i], Times::real_time($tests[$i]));
            }
        }

        public function testAddTimes(){
            $data1=["1d 2h 3","2h 30","4h","5"];
            $data2=["1d","3h 30","4h 30","1d 5"];
            $expected=["2d 2h 3","6h","1d 30","1d 10"];
            for($i=0;$i<count($data1);$i++){
                $d1=$data1[$i];
                $d2=$data2[$i];
                $this->assert($expected[$i],Times::addTimes($d1,$d2));
            }
        }
    }

?>