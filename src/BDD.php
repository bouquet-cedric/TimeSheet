<?php

class BDD {
        private $DB=null;
        private $months=array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
        private $days=array(
            "Monday"=>"Lundi",
            "Tuesday"=>"Mardi",
            "Wednesday"=>"Mercredi",
            "Thursday"=>"Jeudi",
            "Friday"=>"Vendredi",
            "Saturday"=>"Samedi",
            "Sunday"=>"Dimanche"
        );

        function __construct(){
            $this->getDB();
        }

        function reinitDatabase(){
            try {

                $stmt=$this->DB->prepare("delete from tasks");
                $stmt->execute();
                $stmt=$this->DB->prepare("update sqlite_sequence set SEQ=0 where name='tasks'");
                $stmt->execute();
            }
            catch (PDOException $p){
                echo $p->getMessage();
            }
        }

        function createTasks($name){
            $this->DB->query('create table if not exists '.$name.' (
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
                    $this->createTasks("tasks");
                }
                return $this->DB;
            }
            catch(PDOException $e) {
                echo "<span class='erreur'>Database connexion impossible : ".$e->getMessage()."</span>";
                die;
            }
        }

        function addSave(){
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
                <form action='' method='post'>
                    <input type='submit' title='Charge la dernière sauvegarde\n&#9888;Efface les valeurs courantes' value='&#10227' name='loadSave'/>
                </form>";
            }
            if (isset($_POST['loadSave'])){
                $tmp = new BDD();
                $tmp->reinitDatabase();
                $tmp->getDB();
                $tmp->loadSinceSave();
            }
        }

        function loadSinceSave(){
            $this->DB->query("insert into tasks select * from copy_tasks;");
        }

        function makeSave(){
            $this->DB->query("drop table if exists copy_tasks;");
            $this->createTasks("copy_tasks");
            $this->DB->query("insert into copy_tasks (jira, date_t, time_t, date, time, comment, day, month, year)
             SELECT jira, date_t, time_t, date, time, comment, day, month, year from tasks
             WHERE id in ( SELECT id
                    FROM tasks 
                    ORDER BY year desc,month desc,day desc) order by year,month,day,jira;");
        }

        function addTask($jira,$date,$time,$comment){
            try {
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
            catch(Exception $e){
                echo $e->getMessage();
                die();
            }
        }

        function deleteTask($id){
            try {
                $stmt=$this->DB->prepare("delete from tasks where id = :id;");
                $stmt->execute(array(
                    'id' => $id
                ));
            }
            catch (PDOException $p){
                echo $p->getMessage();
                die();
            }
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
        
        private function getFormat($date){
            $jour=explode(" ",$date)[0];
            $date=explode(" ",$date)[1];
            $d=explode("-",$date)[0];
            $m=explode("-",$date)[1];
            $y=explode("-",$date)[2];
            $index=($m-'0')-1;
            $jour=$this->days[$jour];
            $mois=$this->months[$index];
            return $jour." $d ".$mois." ".$y;
        }

        function getDates(){
            $req="select distinct date from tasks order by year,month,day asc;";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo "<div class='detailDate'>";
            echo "<form action='' method='post' autocomplete='off' class='formular'>";
            echo "<input autofocus pattern='[A-Z][a-z]* ([0-9]{2}-)*[0-9]{4}' class='dater' list='dates' name='datas' required/>";
            echo "<datalist id='dates'>";
            foreach($result as $k => $v){
                $format=$this->getFormat($v['date']);
                echo "<option value='".$v['date']."'>".$format."</option>";
            }
            echo "</datalist>";
            echo "<input type='submit' name='getDay' value='Afficher'/>";
            echo "</form>";
            if (isset($_POST['getDay'])){
                $date=$_POST['datas'];
                $format=$this->getFormat($date);
                echo "<br><h3>Tâches du ".$format."</h3>";
                $this->getTaskAt($_POST['datas'],"detail-day.php?datas=".$_GET['datas']);
            }
            else if (isset($_GET['datas'])){
                $date=$_GET['datas'];
                $date=str_replace('%20',' ',$date);
                $format=$this->getFormat($date);
                echo "<br><h3>Tâches du ".$format."</h3>";
                $this->getTaskAt($_GET['datas'],"detail-day.php?datas=".$_GET['datas']);
            }
            echo "</div>";
        }

        function getByTask(){
            $req="select distinct jira,comment from tasks order by jira asc;";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo "<div class='detailDate'>";
            echo "<form action='' method='post' autocomplete='off' class='formular'>";
            echo "<input autofocus class='dater' list='tasks' name='task' required/>";
            echo "<datalist id='tasks'>";
            foreach($result as $k => $v){
                echo "<option value='".$v['jira']."'>".$v['comment']."</option>";
            }
            echo "</datalist>";
            echo "<input type='submit' name='getTask' value='Afficher'/>";
            echo "</form>";
            if (isset($_POST['getTask'])){
                $task=$_POST['task'];
                $this->getDetailTask($task);
            }
            else if (isset($_GET['task'])){
                $task=$_GET['task'];
                $this->getDetailTask($task);
            }
            echo "</div>";
        }

        private function getDetailTask($task){
            $stmt= $this->DB->prepare("select * from tasks where jira=:task");
            $stmt->execute(array(
                'task'=>$task
            ));
            $result=$stmt->fetchAll();
            $Totaltime=0;
            $com=array();
            $cptCom=0;
            $days=array();
            $cptDays=0;
            $times=[];
            $cptTimes=0;
            for($i=0;$i<count($result);$i++){
                foreach ($result[$i] as $k=>$v){
                    if ($k == "time"){
                        $Totaltime+=$this->splitTime($v);
                        $times[$cptTimes]=$this->splitTime($v);
                        $cptTimes++;
                    }
                    else if ($k == "comment"){
                        $com[$cptCom] = $v;
                        $cptCom++;

                    }
                    else if ($k == "date"){                    
                        $days[$cptDays]=$this->getFormat($v);
                        $cptDays++;
                    }
                }
            }
            echo "<h3>$task</h3>";
            echo "<h4>Jours : </h4>";
            echo "<ul>";
            for ($i=0;$i<count($times);$i++)
                echo "<li class='timeday'>$days[$i] - $com[$i] : $times[$i] minutes</li>";
            echo "</ul>";
            $total=$Totaltime;
            $globalDays=floor($Totaltime/480);
            $Totaltime-=$globalDays * 480;
            $globalHours=floor($Totaltime/60);
            $Totaltime-=$globalHours * 60;
            $globalMinutes=$Totaltime;
            $formatTime="";
            if ($globalDays>0)
                $formatTime="$globalDays ".($globalDays>1?"jours":"jour");
            if ($globalHours>0)
                $formatTime=$formatTime." $globalHours ".($globalHours>1?"heures":"heure");
            if ($globalMinutes>0)
                $formatTime=$formatTime." $globalMinutes ".($globalMinutes>1?"minutes":"minute");
            echo "<br><span class='taskTime'><u>Temps total :</u> $total minutes, soit $formatTime</span>";
        }

        private static function addTimes($time1,$time2){
            $sp1=BDD::splitTime($time1);
            $sp2=BDD::splitTime($time2);
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
                            $finalTime=BDD::addTimes($elt['time'],$time);
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

        function getDataListJirasComment(){
            $req="SELECT distinct jira, comment FROM tasks";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $jiraList="<datalist id='allJiras'>";
            for ($i=0;$i<count($result);$i++){
                foreach ($result[$i] as $key => $val){
                    if ($key=='jira')
                        $jira=$val;
                    else if ($key=='comment')
                        $comment=$val;
                }
                $jiraList="$jiraList<option comment='$comment' value='$jira'>$comment</option>";
            }
            $jiraList="$jiraList</datalist>";
            return $jiraList;
        }

        function getTasks($number=10){
            $req="SELECT jira, comment, date, time, date_t, time_t,id from tasks where id in ( SELECT id
                    FROM tasks 
                    ORDER BY year desc,month desc,day desc limit $number) order by year,month,day,jira;";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo "<table class='tasks-list'><thead><tr>";
            $columns=explode(',',"jira,commentaire,date,time,update-date,update-time,action");
            for ($i=0;$i<count($columns);$i++){
                echo "<th class='$columns[$i]'>$columns[$i]</th>";
            }
            echo "</thead><thbody>";
            for ($i=0;$i<count($result);$i++){
                echo "<tr>";
                $cls="";
                if ($i %2 == 0) $cls="pair";
                else $cls="impair";
                foreach ($result[$i] as $key => $val){
                    if ($key=='jira'){
                        echo "<td class='$cls $key'><a target='_blank' href='https://jira.worldline.com/browse/".$val."'>".$val."</a></td>";
                    }
                    else if ($key=='id')
                        echo "
                        <td class='$cls $key'>
                            <form action='deleteTask.php' method='post'>
                                <input type='hidden' value='$val' name='id'/>
                                <input type='submit' value='X' name='deleteTask'/>
                            </form>
                        </td>";
                    else {
                        echo "<td class='$cls $key'>$val</td>";
                    }
                }
                echo "<tr>";
            }
            echo "<form autocomplete='off' action='addTask.php' method='post'>
            <tfoot>
            <tr>
            <td class='jira'><input type='list' id='jiras-input' oninput='fillComment()' placeholder='jira' name='jira' list='allJiras' autofocus required/>".$this->getDataListJirasComment()."</td>
            <td class='comment'><input type='text' name='com' id='commentary' required placeholder='commentaire'/> </td>
            <td class='date'><input type='text' name='date' placeholder='00/00/0000' pattern='[0-9]{2}/[0-9]{2}/[0-9]{4}' required/> </td>
            <td class='time'><input type='text' name='time' placeholder='1d 1h 30' pattern='-*([0-9]{1,2} *d)* *([0-9]{1,2} *h)* *[0-9]{0,2}' required/> </td>
            <td class='date_t'><input disabled placeholder='autocomplete'/> </td>
            <td class='time_t'><input disabled placeholder='autocomplete'/> </td>
            <td class='id'><input type='submit' name='addTask' value='+'/> </td>
            </tr>
            </tfoot>
            </form>
            ";
            echo "</table></div>";
        }

        private static function in ($chaine,$elt){
            $len=strlen($chaine);
            for ($i=0;$i<$len;$i++){
                if ($chaine[$i]==$elt)
                    return true;
            }
            return false;
        }

        private static function splitTime($time){
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
            if ( ! BDD::in($time,'d') && ! BDD::in($time,'h')) return $time;
            return $days*8*60+$hours*60+$minutes;
        }
        
        function getTaskAt($date,$redirection=null){
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
                        $globalTime+=BDD::splitTime($val);
                    }
                    else if ($key=='id')
                        echo "
                        <td class='$cls'>
                            <form action='deleteTask.php' method='post'>
                                <input type='hidden' value='$val' name='id'/>
                                <input type='hidden' value='$redirection' name='redirect'/>
                                <input type='submit' value='X' name='deleteTask'/>
                            </form>
                        </td>";
                    else {
                        echo "<td class='$cls'>$val</td>";
                    }
                }
                echo "<tr>";
            }
            $format=explode(' ',$date)[1];
            $format=str_replace('-','/',$format);
            echo "<form autocomplete='off' action='addTask.php' method='post'>
            <tfoot>
            <tr>
            <td class='jira'><input type='list' id='jiras-input' oninput='fillComment()' placeholder='jira' name='jira' list='allJiras' autofocus required/>".$this->getDataListJirasComment()."</td>
            <td class='comment'><input type='text' name='com' id='commentary' required placeholder='commentaire'/> </td>
            <input type='hidden' name='date' value='$format'/>
            <input type='hidden' name='redirect' value='detail-day.php?datas=$date'/>
            <td class='time'><input type='text' name='time' placeholder='1d 1h 30' pattern='-*([0-9]{1,2} *d)* *([0-9]{1,2} *h)* *[0-9]{0,2}' required/></td>
            <td class='date_t'><input disabled placeholder='autocomplete'/> </td>
            <td class='time_t'><input disabled placeholder='autocomplete'/> </td>
            <td class='id'><input type='submit' name='addTask' value='+'/> </td>
            </tr>
            </tfoot>
            </form></table>";
            $globalHours=floor($globalTime/60);
            $globalMinutes=$globalTime - $globalHours * 60;

            $labelMin=($globalMinutes>1)?"minutes":"minute";
            $labelHours=($globalHours>1)?"heures":"heure";

            $timinutes=($globalMinutes>0?"$globalMinutes $labelMin":"");
            $timhours=($globalHours>0?"$globalHours $labelHours":"");

            $timing = ($globalHours>0)?"$timhours ".($globalMinutes>0?"et $timinutes":""):$timinutes;
            echo "<h4>Temps total : $timing</h4>";
        }

        function getPannelTaskAt($date){
            $req="select jira, comment, time, id from tasks where date like '%$date%' order by jira asc;";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if (count($result)>0){

                $res="";
                for ($i=0;$i<count($result);$i++){
                    // $res=$res."<td class='button'>";
                    $head="<td class='button";
                    $line="";
                    $classSup="";
                    foreach ($result[$i] as $key => $val){
                        if ($key=='jira'){
                            $line=$line."<div class='invisible'><a target='_blank' class='jira' href='https://jira.worldline.com/browse/".$val."'>$val</a>";
                        }
                        else if ($key=='id'){
                            $line=$line."<form action='deleteTask.php' method='post'>".
                            "<input type='hidden' value='".$val."' name='id'/>".
                            "<input type='hidden' value='planning.php' name='redirect'/>".
                            "<input type='submit' class='delete' value='X' name='deleteTask'/>".
                            "</form></div>";
                        }
                        else if ($key=='comment'){
                            $line=$line."<br><span class='planningCom'>$val</span>";
                            switch ($val) {
                                case stripos($val,"daily") !== false:
                                    $classSup=$classSup." ".$val;
                                    break;
                                case stripos($val,"environnement") !== false:
                                    $classSup=$classSup." environnement";
                                    break;
                                case stripos($val,"environment") !== false:
                                    $classSup=$classSup." environnement";
                                    break;
                                case stripos($val,"non working day") !== false:
                                    $classSup=$classSup." non-working-day";
                                    break;
                                case stripos($val,"congés") !== false:
                                    $classSup=$classSup." non-working-day";
                                    break;
                                default:
                                    break;
                            }
                            $head=$head.$classSup."'>";
                        }
                        else if ($key=='time'){
                            $line=$line."<br><span class='planningCom'>$val</span>";
                        }
                    }
                    $line=$line."</td>";
                    $res=$res.$head.$line;
                }
                return $res;
            }
        }
            
        private static function logger($res){
            echo "<script>console.log(\"".$res."\");</script>";
        }

        private static function bissextile($annee) {
            if( (is_int($annee/4) && !is_int($annee/100)) || is_int($annee/400)) {
                return true;
            } else {
                return false;
            }
        }

        function addCalendar(){
            echo "
            <form action='' autocomplete='off' method='post' class='formular'>
                <input type='list' list='years' class='dater' autofocus pattern='[0-9]{4}' name='yearToShow' required>
                <datalist id='years'>";
                for ($i=2020;$i<2030;$i++){
                    echo "<option value='$i'>$i</option>";
                }
                echo "
                </datalist>
                <input type='submit' value='Afficher' name='getCalendar'/>
            </form>
                ";
            if (isset($_POST['getCalendar'])){
                echo "<h3>Année ".$_POST['yearToShow']."</h3>";
                echo "<div id='calendar' class='calendus'>";
                $this->showCalendar($_POST['yearToShow']);
                echo "</div>";
            }
        }

        function showDay($d,$m,$year){
            $day=$this->getDay("$d/$m/$year");
            $jour=explode(" ",$day)[0];
            $date=explode(" ",$day)[1];
            $fmt=str_replace('-','/',$date);
            $fmt=str_replace('/'.$year,'',$fmt);
            $index=($m-'0')-1;
            $fmt=str_replace('/'.$m,' '.$this->months[$index],$fmt);
            $numero=explode(' ',$fmt)[0];
            $mois=explode(' ',$fmt)[1];
            $jour=$this->days[$jour];
            echo "
            <td>
                <table class='pannelTask'>
                    <tr>
                        <td class='calendar-day' colspan='8'>".$jour."</td>
                    </tr>
                    <tr>
                        <td class='calendar-num' colspan='8'>".$numero."</td>
                    </tr>
                    <tr>
                        <td class='calendar-month' colspan='8'>".$mois."</td>
                    </tr>
                    <tr>".$this->getPannelTaskAt($date)."
                    </tr>
                </table>
            </td>";
        }

        function showCalendar($year){
            echo "<div class='manager_month'>";
            echo "<button onclick='previousMonth()'>&#9664;</button>";
            echo "</div>";
            $year=$year-'0';
            $fevrier=28;
            if (BDD::bissextile($year)) $fevrier=29;
            $months=array(31,$fevrier,31,30,31,30,31,31,30,31,30,31);
            echo "<table class='calendar'>";
            for ($i=0;$i<12;$i++){
                echo "<tr class='month_".($i+1)."'>";
                for ($j=1;$j<=$months[$i];$j++){
                    $m=($i+1)>9?($i+1):'0'.($i+1);
                    $d=$j>9?$j:'0'.$j;
                    $this->showDay($d,$m,$year);
                    if ($j %7 ==0) echo "</tr><tr class='month_".($i+1)."'>";
                }
                echo "</tr>";
            }
            echo "</table>
            <div class='manager_month'>
                <button onclick='nextMonth()'>&#9654;</button>
            </div>
            <footer class='legendePlanning'>
                <h4>Légende</h4>
                <span class='legend daily'></span><span>Daily</span><br>
                <span class='legend non-working-day'></span><span>Jours non travaillés</span><br>
                <span class='legend environnement'></span><span>Problèmes d'environnement</span><br>
                <span class='legend task'></span><span>Ticket</span><br>
            </footer>
            <script>
                initMonth();
                isActive=true;
            </script>";
        }
    }

    ?>
