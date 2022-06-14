<?php

    require_once(__DIR__."/template.php");

    class UtilityTest extends TestClass{
        
        /**
         * @test
         * @return void
         */
        public function testIn(){
            $chaines=["chien","chat","souris","avion","camion","De Gaulle","Napoléon","Pluton"];
            $elements=["c/C","h/H","s/S","a/A","m/c","D/G/a/A","N/n/é/O","P/p"];
            $expected=["t/f","t/f","t/f","t/f","t/t","t/t/t/f","t/t/t/f","t/f"];
            for ($i=0;$i<count($chaines);$i++){
                $subject=$chaines[$i];
                $element=explode("/",$elements[$i]);
                $expect=explode("/",$expected[$i]);
                for ($j=0;$j<count($element);$j++){
                    if ($expect[$j]=="t"){
                        $this->assert_true(Utility::in($subject,$element[$j]));
                    }
                    else if ($expect[$j]=="f"){
                        $this->assert_false(Utility::in($subject,$element[$j]));
                    }
                }
            }
        }

        public function testRealNumber(){
            $data=["9","10","11","5"];
            $expect=["09","10","11","05"];
            $errors=["9","010","011","5"];
            for ($i=0;$i<count($data);$i++){
                $this->assert($expect[$i],Utility::getRealNumber($data[$i]));
                $this->not_assert($errors[$i],Utility::getRealNumber($data[$i]));
            }
            $erratum=["a","A","Hello"];
            $cpt_check=0;
            for ($i=0;$i<count($erratum);$i++){
                try {
                    Utility::getRealNumber($erratum[$i]);
                }
                catch(Exceptor $e){
                    $cpt_check++;
                    $this->assert(EXPECT_NUMBER_STRING,$e->getMessage());
                }
            }
            $this->assert(count($erratum),$cpt_check);
        }

        public function simpletest($data,$exp,$func){
            for ($i=0; $i<count($data); $i++){
                $this->assert($exp[$i]." ",$func($data[$i]));
            }
        }

        public function testMoment(){
            $datas=["Pb environnement","congés",NWD,"non working day","jour férié","daily + making of",DLY,"OTHER"];
            $expect=[ENV,NWD,NWD,NWD,NWD,DLY,DLY,""];
            for ($i=0; $i<count($datas); $i++){
                $this->assert($expect[$i]." ",Utility::moment($datas[$i]));
            }
        }
        
        public function testValueTT(){            
            $datas=["home","Home","Work","work","no-work","No Work","No-work"];
            $expect=['&#128104;&#8205;&#128187;','','','&#8986;','&#129523;','',''];
            for ($i=0; $i<count($datas); $i++){
                $this->assert($expect[$i],Utility::getValueTT($datas[$i]));
            }
        }

        public function testPlaceFromTtValue(){            
            $datas=["home","Home","Work","work","no-work","No Work","No-work"];
            $expect=['Télétravail','','','Bureau','Absent','',''];
            for ($i=0; $i<count($datas); $i++){
                $this->assert($expect[$i],Utility::getPlaceFromTtValue($datas[$i]));
            }
        }
    }


?>