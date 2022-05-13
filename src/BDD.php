<?php

class BDD {
        private $DB=null;

        function __construct(){
            $this->getDB();
        }

        function reinitDatabase(){
            $this->DB->query("delete from tasks");
            $this->DB->query("drop table tasks;");
        }

        function createTasks(){
            $this->DB->query('create table if not exists tasks (
                id integer primary key autoincrement,
                jira varchar NOT NULL,
                date_t date NOT NULL,
                time_t time NOT NULL,
                date date NOT NULL,
                time varchar NOT NULL,
                comment varchar,
                day int,
                month int,
                year int
            );');
        }

        function getDB(){
            try {
                if ($this->DB==null){
                    $this->DB=new PDO('sqlite:database.sqlite',"","",array(PDO::ATTR_PERSISTENT => true));
                    $this->DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // $this->reinitDatabase();
                    $this->createTasks();
                }
                return $this->DB;
            }
            catch(PDOException $e) {
                echo "<span class='erreur'>Database connexion impossible : ".$e->getMessage()."</span>";
                die;
            }
        }

        function addButtonSave(){
            echo "
            <form action='' method='post'>
                <input type='submit' title='Créer sauvegarde' value='&#128190;' name='makeSave'/>
            </form>";
            if (isset($_POST['makeSave'])){
                $this->makeSave();
            }
        }
            
        function loadSave(){
            $requete="SELECT name FROM sqlite_master WHERE type='table' AND name='copy_tasks'";
            $stmt=$this->DB->prepare($requete);
            $stmt->execute();
            $res=$stmt->fetch();
            if ($res['name'] == 'copy_tasks') {
                echo "
                <form action='loadSave.php' method='post'>
                    <input type='submit' title='Charge la dernière sauvegarde\n&#9888;Efface les valeurs courantes' value='&#10227' name='loadSave'/>
                </form>";
            }
        }

        function loadSinceSave(){
            $this->DB->query("insert into tasks select * from copy_tasks;");
        }

        function makeSave(){
            $this->DB->query("drop table if exists copy_tasks;");
            $this->DB->query('create table if not exists copy_tasks (
                id integer primary key autoincrement,
                jira varchar NOT NULL,
                date_t date NOT NULL,
                time_t time NOT NULL,
                date date NOT NULL,
                time varchar NOT NULL,
                comment varchar,
                day int,
                month int,
                year int
            );');
            $this->DB->query("insert into copy_tasks (jira, date_t, time_t, date, time, comment, day, month, year)
             select jira, date_t, time_t, date, time, comment, day, month, year from tasks;");
        }

        function addTask($jira,$date,$time,$comment){
            $day=substr($date,0,2);
            $mon=substr($date,3,2);
            $year=substr($date,6,4);
            $isUpdated = $this->updateTime($day,$mon,$year,$jira,$time);
            if (! $isUpdated){
                $stmt=$this->DB->prepare("insert into tasks (jira,date_t,time_t,date,time,comment,day,month,year) values (:jira,:dt,:tt,:date,:time,:com,:d,:m,:y);");
                $datum=$this->getToday();
                $stmt->execute(array(
                    'jira' => $jira,
                    'dt' => $datum[0],
                    'tt' => $datum[1],
                    'date' => $this->getDay($date),
                    'time' => $time,
                    'com' => $comment,
                    'd' => $day,
                    'm' => $mon,
                    'y' => $year 
                ));
            }
        }

        function deleteTask($id){
            $stmt=$this->DB->prepare("delete from tasks where id = :id;");
            $stmt->execute(array(
                'id' => $id
            ));
        }

        private function getRealNumber($champDate){
            return $champDate>9?$champDate:'0'.$champDate;
        }

        function getDate($d){
            setlocale(LC_ALL,'fr_FR','French');
            setlocale(LC_TIME, 'fr_FR.utf8','fra');
            date_default_timezone_set('Europe/Paris');
            $dday=$d['weekday'];
            $month=$this->getRealNumber($d['mon']);
            $day=$this->getRealNumber($d['mday']);
            $year=$d['year'];
            $fdate=$dday.' '.implode('-',[$day,$month,$year]);
            $hours=$this->getRealNumber($d['hours']);
            $minutes=$this->getRealNumber($d['minutes']);
            $seconds=$this->getRealNumber($d['seconds']);
            $ftime=implode(':',[$hours,$minutes,$seconds]);
            return [$fdate,$ftime];
        }

        function getToday(){
            $d=getdate();
            return $this->getDate($d);
        }
        
        function getDay($day){
            $reformateDay=substr($day,3,3).substr($day,0,3).substr($day,-4);
            $d=getdate(strtotime($reformateDay));
            return $this->getDate($d)[0];
        }

        function getDates(){
            $req="select distinct date from tasks order by year,month,day asc;";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo "<div class='detailDate'>";
            echo "<form action='' method='post'>";
            echo "<select name='datas'>";
            foreach($result as $k => $v){
                $onlyone=explode(" ",$v['date'])[1];
                echo "<option value='".$v['date']."'>".$onlyone."</option>";
            }
            echo "</select>";
            echo "<input type='submit' name='getDay' value='Afficher le détail'/>";
            echo "</form>";
            if (isset($_POST['getDay'])){
                echo "<br><h3>Tâches du ".$_POST['datas']." :</h3>";
                $this->getTaskAt($_POST['datas']);
            }
            echo "</div>";
        }

        private function addTimes($time1,$time2){
            $sp1=$this->splitTime($time1);
            $sp2=$this->splitTime($time2);
            $globalTime=$sp1+$sp2;
            $globalHours=floor($globalTime/60);
            $globalMinutes=$globalTime - $globalHours * 60;

            $timhours=($globalHours>0?$globalHours."h":"");
            $timinutes=($globalMinutes>0?$globalMinutes:"");
            $timing = $timhours.$timinutes;
            return $timing;
        }

        function updateTime($day,$month,$year,$jira,$time){
            $stmt=$this->DB->prepare("select * from tasks where day=:d and month=:m and year=:y;");
            $stmt->execute(array(
                'd' => $day,
                'm' => $month,
                'y' => $year
            ));
            $result=$stmt->fetchAll();
            $execute=false;
            for ($i=0;$i<count($result);$i++){
                $elt=$result[$i];
                foreach ($elt as $k => $v){
                    if ($k == 'jira'){
                        if ($v == $jira){
                            $finalTime=$this->addTimes($elt['time'],$time);
                            $execute=true;
                            $stmt=$this->DB->prepare("update tasks set time = :time where jira=:j and day=:d and month=:m and year=:y;");
                            $stmt->execute(array(
                                'd' => $day,
                                'm' => $month,
                                'y' => $year,
                                'j' => $jira,
                                'time' => $finalTime
                            ));
                        }
                    }
                }
            }
            return $execute;
        }

        function getTasks(){
            $req="SELECT jira, comment, date, time, date_t, time_t,id from tasks where id in ( SELECT id
                    FROM tasks 
                    ORDER BY year desc,month desc,day desc limit 10) order by year,month,day,jira;";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo "<table><tr>";
            $columns=explode(',',"jira,commentaire,date,time,update-date,update-time,action");
            for ($i=0;$i<count($columns);$i++){
                echo "<th class='$columns[$i]'>$columns[$i]</th>";
            }
            for ($i=0;$i<count($result);$i++){
                echo "<tr>";
                $cls="";
                if ($i %2 == 0) $cls="pair";
                else $cls="impair";
                foreach ($result[$i] as $key => $val){
                    if ($key == "real_date");
                    else if ($key=='jira'){
                        echo "<td class='$cls'><a target='_blank' href='https://jira.worldline.com/browse/".$val."'>".$val."</a></td>";
                    }
                    else if ($key=='id')
                        echo "
                        <td class='$cls'>
                            <form action='deleteTask.php' method='post'>
                                <input type='hidden' value='$val' name='id'/>
                                <input type='submit' value='X' name='deleteTask'/>
                            </form>
                        </td>";
                    else {
                        echo "<td class='$cls'>$val</td>";
                    }
                }
                echo "<tr>";
            }
            echo "<form action='addTask.php' method='post'>
            <tr>
                <td><input type='text' name='jira' required/> </td>
                <td><input type='text' name='com' required placeholder='commentaire'/> </td>
                <td><input type='text' name='date' placeholder='00/00/00' required/> </td>
                <td><input type='text' name='time' required/> </td>
                <td><input disabled placeholder='autocomplete'/> </td>
                <td><input disabled placeholder='autocomplete'/> </td>
                <td><input type='submit' name='addTask' value='+'/> </td>
            </tr>
            </form>
            ";
            echo "</table>";
        }

        private function in ($chaine,$elt){
            $len=strlen($chaine);
            for ($i=0;$i<$len;$i++){
                if ($chaine[$i]==$elt)
                    return true;
            }
            return false;
        }

        private function splitTime($time){
            $time=str_replace(' ','',$time);
            $len=strlen($time);
            $days=0;
            $hours=0;
            $minutes=0;
            $reste=$time;
            for ($i=0;$i<$len;$i++){
                if ($time[$i]=='d'){
                    $days=explode('d',$time)[0]-'0';
                    $reste=explode('d',$time)[1];
                }
                if ($time[$i]=='h'){
                    $hours=explode('h',$reste)[0]-'0';
                    if ($i<$len-1)
                        $minutes=explode('h',$reste)[1]-'0';
                }
            }
            if ( ! $this->in($time,'d') && ! $this->in($time,'h')) return $time;
            return $days*8*60+$hours*60+$minutes;
        }
        
        function getTaskAt($date){
            $req="select jira, comment, time, date_t, time_t, id from tasks where date like '%$date%' order by jira asc;";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo "<table><tr>";
            $columns=explode(',',"jira,commentaires,time,update-date,update-time,action");
            $globalTime=0;
            for ($i=0;$i<count($columns);$i++){
                echo "<th>$columns[$i]</th>";
            }
            for ($i=0;$i<count($result);$i++){
                echo "<tr>";
                $cls="";
                if ($i %2 == 0) $cls="pair";
                else $cls="impair";
                foreach ($result[$i] as $key => $val){
                    if ($key=='jira'){
                        echo "<td class='$cls'><a target='_blank' href='https://jira.worldline.com/browse/".$val."'>".$val."</a></td>";
                    }
                    else if ($key=='time'){
                        echo "<td class='$cls'>".$val."</td>";
                        $globalTime+=$this->splitTime($val);
                    }
                    else if ($key=='id')
                        echo "
                        <td class='$cls'>
                            <form action='deleteTask.php' method='post'>
                                <input type='hidden' value='$val' name='id'/>
                                <input type='submit' value='X' name='deleteTask'/>
                            </form>
                        </td>";
                    else {
                        echo "<td class='$cls'>$val</td>";
                    }
                }
                echo "<tr>";
            }
            echo "</table>";
            $globalHours=floor($globalTime/60);
            $globalMinutes=$globalTime - $globalHours * 60;

            $labelMin=($globalMinutes>1)?"minutes":"minute";
            $labelHours=($globalHours>1)?"heures":"heure";

            $timinutes=($globalMinutes>0?"$globalMinutes $labelMin":"");
            $timhours=($globalHours>0?"$globalHours $labelHours":"");

            $timing = ($globalHours>0)?"$timhours ".($globalMinutes>0?"et $timinutes":""):$timinutes;
            echo "Temps total : $timing";
        }
    }

    ?>