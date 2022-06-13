<?php

define("DEFAULT_TITLE","Click me");

function addLink($page,$icon,$name,$title=DEFAULT_TITLE){
    echo "
        <div class='flexibus'>
            <form action='$page' method='post'>
                <input type='submit' title=\"$title\" value=\"$icon\"/>
            </form>
            <span title=\"$title\">$name</span>
        </div>
        ";
}

function addButtonLink($page,$icon,$name,$title=DEFAULT_TITLE){
    if ($title==DEFAULT_TITLE) {
        $title = $name;
    }
    echo "
        <div class='fleximenu'>
            <form action='$page' method='post'>
                <input type='submit' class='link_button' title=\"$title\" value=\"$icon\"/>
            </form>
            <span title=\"$title\">$name</span>
        </div>
        ";
}

class Utility {
    public static function in ($chaine,$elt){
        $len=strlen($chaine);
        for ($i=0;$i<$len;$i++){
            if ($chaine[$i]==$elt){
                return true;
            }
        }
        return false;
    }

    public static function getInvisibleTask($tableau){
        $head="<td class='button";
        $line="";
        foreach ($tableau as $key => $val){
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
                $head=$head.Utility::moment($val)."'>";
            }
            else if ($key=='time'){
                $line=$line."<br><span class='planningCom'>$val</span>";
            }
        }
        $line="$line</td>";
        return $head.$line;
    }

    public static function getRealNumber($champDate){
        $isMenorTen=($champDate[0]=='0'?$champDate:'0'.$champDate);
        return $champDate>9?$champDate:$isMenorTen;
    }

    public static function moment($val){
        $classSup="";
        define('NWD',"non-working-day");
        define('ENV',"environnement");
        switch ($val) {
            case stripos($val,"daily") !== false:
                $classSup=$classSup." ".$val;
                break;
            case stripos($val,ENV) !== false:
                $classSup=$classSup." ".ENV;
                break;
            case stripos($val,"non working day") !== false:
                $classSup=$classSup." ".NWD;
                break;
            case stripos($val,"congés") !== false:
                $classSup=$classSup." ".NWD;
                break;
            case stripos($val,"férié") !== false:
                $classSup=$classSup." ".NWD;
                break;
            default:
                break;
        }
        return $classSup;
    }

    public static function logger($res){
        echo "<script>console.log(\"".$res."\");</script>";
    }

    public static function getValueTT($momentDay){
        $res="";
        switch($momentDay){
            case 'home':
                $res='&#128104;&#8205;&#128187;';
                break;
            case 'work':
                $res='&#8986;';
                break;
            case 'no-work':
                $res='&#129523;';
                break;
            default:
                $res='';
                break;
        }
        return $res;
    }

    public static function getPlaceFromTtValue($momentDay){
        $res="";
        switch($momentDay){
            case 'home':
                $res='Télétravail';
                break;
            case 'work':
                $res='Bureau';
                break;
            case 'no-work':
                $res='Absent';
                break;
            default:
                $res='';
                break;
        }
        return $res;
    }
}
class Times {
    public static $months=array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
    public static $days=array(
        "Monday"=>"Lundi",
        "Tuesday"=>"Mardi",
        "Wednesday"=>"Mercredi",
        "Thursday"=>"Jeudi",
        "Friday"=>"Vendredi",
        "Saturday"=>"Samedi",
        "Sunday"=>"Dimanche"
    );
    public static function addTimes($time1,$time2){
        $sp1=Times::splitTime($time1);
        $sp2=Times::splitTime($time2);
        $globalTime=$sp1+$sp2;
        $globalHours=floor($globalTime/60);
        $globalMinutes=$globalTime - $globalHours * 60;

        $timhours=($globalHours>0?$globalHours."h":"");
        $timinutes=($globalMinutes>0?$globalMinutes:"");
        return $timhours.$timinutes;
    }

    public static function bissextile($annee) {
        return (is_int($annee/4) && !is_int($annee/100)) || is_int($annee/400);
    }

    public static function splitTime($time){
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
                if ($i<$len-1){
                    $minutes=explode('h',$reste)[1]-'0';
                }
            }
        }
        if ( ! Utility::in($time,'d') && ! Utility::in($time,'h')) {
            return $time;
        }
        return $days*8*60+$hours*60+$minutes;
    }

    public static function getFormat($date){
        $jour=explode(" ",$date)[0];
        $date=explode(" ",$date)[1];
        $d=explode("-",$date)[0];
        $m=explode("-",$date)[1];
        $y=explode("-",$date)[2];
        $index=($m-'0')-1;
        $jour=Times::$days[$jour];
        $mois=Times::$months[$index];
        return $jour." $d ".$mois." ".$y;
    }

    public static function real_time($total_time){
        $globalDays=floor($total_time/480);
        $total_time-=$globalDays * 480;
        $globalHours=floor($total_time/60);
        $total_time-=$globalHours * 60;
        $globalMinutes=$total_time;
        $formatTime="";
        if ($globalDays>0){
            $formatTime="$globalDays ".($globalDays>1?"jours":"jour");
        }
        if ($globalHours>0){
            $formatTime=$formatTime." $globalHours ".($globalHours>1?"heures":"heure");
        }
        if ($globalMinutes>0){
            $formatTime=$formatTime." $globalMinutes ".($globalMinutes>1?"minutes":"minute");
        }
        return $formatTime;
    }

    public static function getDate($date,$format=null){
        setlocale(LC_ALL,'fr_FR','French');
        setlocale(LC_TIME, 'fr_FR.utf8','fra');
        date_default_timezone_set('Europe/Paris');
        $dday=$date['weekday'];
        $month=Utility::getRealNumber($date['mon']);
        $day=Utility::getRealNumber($date['mday']);
        $year=$date['year'];
        $fdate=$dday.' '.implode('-',[$day,$month,$year]);
        $hours=Utility::getRealNumber($date['hours']);
        $minutes=Utility::getRealNumber($date['minutes']);
        $seconds=Utility::getRealNumber($date['seconds']);
        if ($format == "/") { $ftime=""; }
        else if ($format == "HM") { $ftime=$hours.'h'.$minutes; }
        else if ($format == "HMS") { $ftime=$hours.'h'.$minutes.'m'.$seconds.'s'; }
        else { $ftime=implode(':',[$hours,$minutes,$seconds]); }
        return [$fdate,$ftime];
    }

    public static function getToday($format=null){
        $d=getdate();
        return Times::getDate($d,$format);
    }
    
    public static function getDay($day){
        $reformateDay=substr($day,3,3).substr($day,0,3).substr($day,-4);
        $d=getdate(strtotime($reformateDay));
        return Times::getDate($d)[0];
    }

    public static function getFullDateFR($key){
        $date = Times::getDay(Utility::getRealNumber($key['day'])."/".Utility::getRealNumber($key['month'])."/".Utility::getRealNumber($key['year']));
        $day = explode(" ",$date)[0];
        $jour = Times::$days[$day];
        return str_replace($day,$jour,$date);
    }

    public static function getFullDateFrFromRealDate($date){
        $date=explode(' ',$date)[1];
        $day=explode('-',$date)[0];
        $month=explode('-',$date)[1];
        $year=explode('-',$date)[2];
        $key=[];
        $key["day"] = $day;
        $key["month"] = $month;
        $key["year"] = $year;
        return Times::getFullDateFR($key);
    }
}

class Save {
    static function loadSave(){
        $db=new BDD();
        $requete="SELECT name FROM sqlite_master WHERE type='table' AND name='copy_tasks'";
        $stmt=$db->getDB()->prepare($requete);
        $stmt->execute();
        $res=$stmt->fetch();
        if ($res['name'] == 'copy_tasks') {
            echo "
            <div class='flexibus'>
                <form action='' method='post'>
                    <input type='submit' name='loadSave' title=\"Charge la dernière sauvegarde\n&#9888;Efface les valeurs courantes\" value=\"&#10227;\"/>
                </form>
                <span title=\"Charge la dernière sauvegarde\n&#9888;Efface les valeurs courantes\">Recharge</span>
            </div>
            ";
        }
        if (isset($_POST['loadSave'])){
            $db->reinitDatabase();
            $db->getDB();
            $db->getDB()->query("insert into tasks select * from copy_tasks;");
        }
    }

    static function makeSave(){
        $db=new BDD();
        $db->getDB()->query("drop table if exists copy_tasks;");
        $db->createTable("copy_tasks");
        $db->getDB()->query("insert into copy_tasks (jira, date_t, time_t, date, time, comment, day, month, year)
            SELECT jira, date_t, time_t, date, time, comment, day, month, year from tasks
            WHERE id in ( SELECT id
                FROM tasks 
                ORDER BY year desc,month desc,day desc) order by year,month,day,jira;");
    }

    static function addSave(){
        echo "
        <div class='flexibus'>
            <form action='' method='post'>
                <input type='submit' name='makeSave' title=\"Créer sauvegarde\" value=\"&#128190;\"/>
            </form>
            <span title=\"Créer sauvegarde\">Archive</span>
        </div>
        ";
        if (isset($_POST['makeSave'])){
            Save::makeSave();
        }
    }

    static function csvify(){
        echo "
        <div class='flexibus'>
            <form action='' method='post'>
                <button type='submit' name='makeCsv' title=\"Créer CSV\">
                    <i class='fa-solid fa-file-csv'></i>
                </button>
            </form>
            <span title=\"Créer CSV\">Créer CSV</span>
        </div>
        ";
        if (isset($_POST['makeCsv'])){
            Save::makeCsv();
        }
    }

    static function makeCsv(){
        $basename = getcwd()."/"."saves"."/".Times::getFullDateFrFromRealDate(Times::getToday()[0]);

        $db=new BDD();
        $stmt = $db->getDB()->prepare("select * from tasks;");
        $stmt->execute();
        $result = $stmt->fetchAll();

        $filetasks = $basename." - travail réalisé.csv";
        
        try {
            file_put_contents($filetasks,"Date;Jira;Commentaire;Temps\n", FILE_USE_INCLUDE_PATH);
            foreach ($result as $key){
                file_put_contents($filetasks,Times::getFullDateFR($key).";".$key['jira'].";".$key['comment'].";".$key['time']."\n",FILE_APPEND);
            }
        }
        catch(Exception $e){
            Utility::logger($e->getMessage());
        }
        
        $stmt = $db->getDB()->prepare("select * from teletravail order by year,month,day;");
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $fileworkhouse = $basename." - télétravail.csv";

        try {
            file_put_contents($fileworkhouse,"Date;Matin;Après-midi\n", FILE_USE_INCLUDE_PATH);
            foreach ($result as $key){
                file_put_contents($fileworkhouse,Times::getFullDateFR($key).";".Utility::getPlaceFromTtValue($key['AM']).";".Utility::getPlaceFromTtValue($key['PM'])."\n",FILE_APPEND);
            }
        }
        catch(Exception $e){
            Utility::logger($e->getMessage());
        }
    }
}

class BDD {
    private $DB=null;

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

    function createTable($name){
        if ($name == 'tasks' || $name == 'copy_tasks'){
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
        else if ($name == 'télétravail'){
            $this->DB->query('create table if not exists teletravail (
                id integer primary key autoincrement,
                AM varchar NOT NULL DEFAULT \'work\',
                PM varchar NOT NULL DEFAULT \'work\',
                day int,
                month int,
                year int,
                constraint unicite_TT unique(day,month,year)
            );');
        }
    }

    function getDB(){
        try {
            if ($this->DB==null){
                $this->DB=new PDO('sqlite:database.sqlite',"root","root",array(PDO::ATTR_PERSISTENT => true));
                $this->DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->createTable("tasks");
                $this->createTable("télétravail");
            }
            return $this->DB;
        }
        catch(PDOException $e) {
            echo "<span class='erreur'>Database connexion impossible : ".$e->getMessage()."</span>";
            die;
        }
    }

    function addTask($jira,$date,$time,$comment){
        try {
            $day=substr($date,0,2);
            $mon=substr($date,3,2);
            $year=substr($date,6,4);
            $isUpdated = $this->updateTimeAndComment($day,$mon,$year,$jira,$time,$comment);
            if (! $isUpdated){
                $stmt=$this->DB->prepare("insert into tasks (jira,date_t,time_t,date,time,comment,day,month,year) values (:jira,:dt,:tt,:date,:time,:com,:d,:m,:y);");
                $datum=Times::getToday();
                $stmt->execute(array(
                    'jira' => $jira,
                    'dt' => $datum[0],
                    'tt' => $datum[1],
                    'date' => Times::getDay($date),
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
    
    function getDates(){
        $req="select distinct date from tasks order by year,month,day asc;";
        $stmt=$this->DB->prepare($req);
        $stmt->execute();
        $result = $stmt->fetchAll();
        echo "<div class='detailDate'>";
        echo "<form action='' method='post' autocomplete='off' class='formular'>";
        echo "<input autofocus pattern='[A-Z][a-z]* ([0-9]{2}-)*[0-9]{4}' class='dater' list='dates' name='datas' required/>";
        echo "<datalist id='dates'>";
        foreach($result as $v){
            $format=Times::getFormat($v['date']);
            echo "<option value='".$v['date']."'>".$format."</option>";
        }
        echo "</datalist>";
        echo "<input type='submit' name='getDay' value='Afficher'/>";
        echo "</form>";
        if (isset($_POST['getDay'])){
            $date=$_POST['datas'];
            $format=Times::getFormat($date);
            echo "<br><h3>Tâches du $format</h3>";
            $this->getTaskAt($_POST['datas'],"detail-day.php?datas=".$_GET['datas']);
        }
        else if (isset($_GET['datas'])){
            $date=$_GET['datas'];
            $date=str_replace('%20',' ',$date);
            $format=Times::getFormat($date);
            echo "<br><h3>Tâches du $format</h3>";
            $this->getTaskAt($_GET['datas'],"detail-day.php?datas=".$_GET['datas']);
        }
        echo "</div>";
    }

    function getByTask(){
        echo "<form action='' method='post' autocomplete='off' class='formular'>";
        echo "<input autofocus class='dater' list='allJiras' name='task' required/>";
        echo $this->getDataList("allJiras");
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
                    $Totaltime+=Times::splitTime($v);
                    $times[$cptTimes]=Times::splitTime($v);
                    $cptTimes++;
                }
                else if ($k == "comment"){
                    $com[$cptCom] = $v;
                    $cptCom++;
                }
                else if ($k == "date"){                    
                    $days[$cptDays]=Times::getFormat($v);
                    $cptDays++;
                }
            }
        }
        echo "<h3>$task</h3>
            <nav class='detailTask'>
                <h4>Jours : </h4>
            <ul>";
        for ($i=0;$i<count($times);$i++){
            echo "<li class='timeday'>$days[$i] - $com[$i] : $times[$i] minutes</li>";
        }
        echo "</ul><br><span class='taskTime'><u>Temps total :</u> $Totaltime minutes, soit ".Times::real_time($Totaltime)."</span></nav>";
    }

    function updateTimeAndComment($day,$month,$year,$jira,$time,$comment){
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
                if ($k == 'jira' && $v == $jira){
                    $finalTime=Times::addTimes($elt['time'],$time);
                    $execute=true;
                    $stmt=$this->DB->prepare("update tasks set time = :time, comment = :com where jira=:j and day=:d and month=:m and year=:y;");
                    $stmt->execute(array(
                        'd' => $day,
                        'm' => $month,
                        'y' => $year,
                        'j' => $jira,
                        'time' => $finalTime,
                        'com' => $comment
                    ));
                }
            }
        }
        return $execute;
    }

    function getDataList($name){
        if ($name == "allDates"){        
            $req="SELECT distinct day,month,year FROM tasks";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $datesList="<datalist id='allDates'>";
            foreach ($result as $val){
                $formatTime=Utility::getRealNumber($val['day']).'/'.Utility::getRealNumber($val['month']).'/'.Utility::getRealNumber($val['year']);
                $datesList=$datesList."<option value='".$formatTime."'/>";
            }
            $datesList="$datesList</datalist>";
            return $datesList;
        }
        else if ($name == "allJiras"){
            $req="SELECT distinct jira, comment FROM tasks";
            $stmt=$this->DB->prepare($req);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $jiraList="<datalist id='allJiras'>";
            for ($i=0;$i<count($result);$i++){
                $jira=$result[$i]['jira'];
                $comment=$result[$i]['comment'];
                $jiraList="$jiraList<option comment='$comment' value='$jira'>$comment</option>";
            }
            $jiraList="$jiraList</datalist>";
            return $jiraList;
        }
        return null;
    }

    function getTasks($number=10){
        $req="SELECT jira, comment, date, time, date_t, time_t,id from tasks where id in ( SELECT id
                FROM tasks 
                ORDER BY year desc,month desc,day desc limit $number) order by year,month,day,jira;";
        $stmt=$this->DB->prepare($req);
        $stmt->execute();
        $result = $stmt->fetchAll();
        echo "<div class='tasks-list'><div class='header-list'>";
        $columns=explode(',',"jira,commentaire,date,time,update-date,update-time,action");
        for ($i=0;$i<count($columns);$i++){
            echo "<span class='$columns[$i]'>$columns[$i]</span>";
        }
        echo "</div><table>";
        for ($i=0;$i<count($result);$i++){
            echo "<tr>";
            $cls="";
            if ($i %2 == 0) {$cls="pair";}
            else {$cls="impair";}
            foreach ($result[$i] as $key => $val){
                if ($key=='jira'){
                    echo "<td class='$cls $key'><a target='_blank' href='https://jira.worldline.com/browse/".$val."'>".$val."</a></td>";
                }
                else if ($key=='id'){
                    echo "
                    <td class='$cls $key'>
                        <form action='deleteTask.php' method='post'>
                            <input type='hidden' value='$val' name='id'/>
                            <input type='submit' value='X' name='deleteTask'/>
                        </form>
                    </td>";
                }
                else if ($key=='date' || $key == 'date_t'){
                    $realDate=Times::getFullDateFrFromRealDate($val);
                    echo "<td class='$cls $key'>$realDate</td>";
                }
                else {
                    echo "<td class='$cls $key'>$val</td>";
                }
            
            }
            echo "<tr>";
        }
        echo "</table><form autocomplete='off' action='addTask.php' method='post'>
        <div class='footer-list'>
        <span class='_jira'><input type='list' id='jiras-input' onkeydown='fillComment()' onchange='fillComment()' oninput='fillComment()' placeholder='jira' name='jira' list='allJiras' autofocus required/>".$this->getDataList("allJiras")."</span>
        <span class='_comment'><input type='text' name='com' id='commentary' required placeholder='commentaire'/> </span>
        <span class='_date'><input type='list' list='allDates' name='date' placeholder='00/00/0000' pattern='[0-9]{2}/[0-9]{2}/[0-9]{4}' required/>".$this->getDataList("allDates")."</span>
        <span class='_time'><input type='text' name='time' placeholder='1d 1h 30' pattern='-*([0-9]{1,2} *d)* *([0-9]{1,2} *h)* *[0-9]{0,2}' required/> </span>
        <span class='_date_t'><input disabled placeholder='autocomplete'/> </span>
        <span class='_time_t'><input disabled placeholder='autocomplete'/> </span>
        <span class='_id'><input type='submit' name='addTask' value='+'/> </span>
        </div>
        </form>
        </div>";
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
            if ($i %2 == 0) {$cls="pair";}
            else {$cls="impair";}
            foreach ($result[$i] as $key => $val){
                if ($key=='jira'){
                    echo "<td class='$cls'><a target='_blank' href='https://jira.worldline.com/browse/".$val."'>".$val."</a></td>";
                }
                else if ($key=='time'){
                    echo "<td class='$cls'>$val</td>";
                    $globalTime+=Times::splitTime($val);
                }
                else if ($key=='id'){
                    echo "
                    <td class='$cls'>
                        <form action='deleteTask.php' method='post'>
                            <input type='hidden' value='$val' name='id'/>
                            <input type='hidden' value='$redirection' name='redirect'/>
                            <input type='submit' value='X' name='deleteTask'/>
                        </form>
                    </td>";
                }
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
        <tr class='detailday'>
        <td class='jira'><input type='list' id='jiras-input' oninput='fillComment()' onkeydown='fillComment()' onchange='fillComment()' placeholder='jira' name='jira' list='allJiras' autofocus required/>".$this->getDataList("allJiras")."</td>
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
        echo "<h4>Temps total : ".Times::real_time($globalTime)."</h4>";
    }

    function getPannelTT($d,$m,$y){
        $req="select AM, PM from teletravail where day=:d and month=:m and year=:y";
        $stmt=$this->DB->prepare($req);
        $stmt->execute(array(
            'd'=>$d,
            'm'=>$m,
            'y'=>$y
        ));
        $result = $stmt->fetchAll();
        $keys=array('AM','PM');
        $line="";
        if ($result[0]['AM'] != $result[0]['PM']){
            foreach ($keys as $value){
                $moment=$result[0][$value];
                $line=$line."<td title='$moment' class='$value'>".Utility::getValueTT($moment)."</td>";
            }
            return $line;
        }
        $moment=$result[0]['AM'];
        return "<td title='".$moment."' class='AM-down'>".Utility::getValueTT($moment)."</td>";
    }

    function getPannelTaskAt($date){
        $req="select jira, comment, time, id from tasks where date like '%$date%' order by jira asc;";
        $stmt=$this->DB->prepare($req);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!empty($result)){
            $res="";
            for ($i=0;$i<count($result);$i++){
                $res=$res.Utility::getInvisibleTask($result[$i]);
            }
            return $res;
        }
    }

    function insertOrUpdateTeletravail($day,$month,$year,$moment,$lieu){
        if ($moment == 'ALL_DAY'){
            $this->insertOrUpdateTeletravail($day,$month,$year,'AM',$lieu);
            $this->insertOrUpdateTeletravail($day,$month,$year,'PM',$lieu);
        }
        else {
            $req="select * from teletravail where day=$day and month=$month and year=$year";
            $stmt=$this->DB->query($req)->fetchAll();
            if (count($stmt) > 0){
                $req="update teletravail set $moment=:l where day=:d and month=:m and year=:y";
                $stmt=$this->DB->prepare($req);
                $stmt->execute(array(
                    'l'=>$lieu,
                    'd'=>$day,
                    'm'=>$month,
                    'y'=>$year
                ));
            }
            else {
                $req="insert into teletravail ($moment,day,month,year) values (:l,:d,:m,:y)";
                $stmt=$this->DB->prepare($req);
                $stmt->execute(array(
                    'l'=>$lieu,
                    'd'=>$day,
                    'm'=>$month,
                    'y'=>$year
                ));
            }
        }
    }

    function addDayTT(){
        echo "
        <fieldset class='set-form'>
            <form action='' autocomplete='off' method='post' class='formular absolute'>
                <div>
                    <label>Date :</label>
                    <input type='number' min='1' max='31' placeholder='dd' autofocus class='dater' name='day' required>
                    <input type='number' min='1' max='12' class='dater' placeholder='mm' name='month' required>
                    <input type='number' min='2020' max='2030' class='dater' placeholder='yyyy' name='year' required>
                </div>
                <div>
                    <select class='dater' name='momentum' required>
                        <option value='AM'>Matin</option>
                        <option value='PM'>Après-midi</option>
                        <option value='ALL_DAY'>Journée entière</option>
                    </select>
                </div>
                <div>
                    <select class='dater' name='lieu' required>
                        <option value='work'>Bureau</option>
                        <option value='home'>Maison</option>
                        <option value='no-work'>Congés</option>
                    </select>
                </div>
                <input type='submit' value='Enregistrer' name='pushTT'/>
            </form>
        </fieldset>
                ";
        if (isset($_POST['pushTT'])){
            $day=$_POST['day'];
            $month=$_POST['month'];
            $year=$_POST['year'];
            $momentum=$_POST['momentum'];
            $lieu=$_POST['lieu'];
            try {
                $this->insertOrUpdateTeletravail($day,$month,$year,$momentum,$lieu);
            }
            catch(Exception $e){
                echo "<span class='erreur'>".$e->getMessage()."</span>";
                die();
            }
        }
    }

    function addCalendar($teletravail=false){
        echo "  <form action='' autocomplete='off' method='post' class='formular'>
                    <input type='list' list='years' class='dater' autofocus pattern='[0-9]{4}' name='yearToShow' required>
                    <datalist id='years'>";
        for ($i=2020;$i<2030;$i++){
            echo "      <option value='$i'>$i</option>";
        }
        echo "      </datalist>
                    <input type='submit' value='Afficher' name='getCalendar'/>
                </form>";
        if (isset($_POST['getCalendar'])){
            $year=$_POST['yearToShow'];
            echo "<h3>Année ".$year."</h3>";
            echo "<div id='calendar' class='calendus'>";
            $this->showCalendar($year,$teletravail);
            echo "</div>";
        }
    }

    function showDay($d,$m,$year,$teletravail=false){
        $day=Times::getDay("$d/$m/$year");
        $jour=explode(" ",$day)[0];
        $date=explode(" ",$day)[1];
        $fmt=str_replace('-','/',$date);
        $fmt=str_replace('/'.$year,'',$fmt);
        $index=($m-'0')-1;
        $fmt=str_replace('/'.$m,' '.Times::$months[$index],$fmt);
        $numero=explode(' ',$fmt)[0];
        $mois=explode(' ',$fmt)[1];
        $jour=Times::$days[$jour];
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
                </tr>";
        if ((bool)$teletravail){
            echo "<tr class='teleDay'>".$this->getPannelTT($d,$m,$year);
        }
        else{
            echo "<tr>".$this->getPannelTaskAt($date);
        }
        echo "</tr></table></td>";
    }
    
    function showCalendar($year,$teletravail=false){
        echo "
        <div class='manager_month'>
            <button onclick='previousMonth()'>&#9664;</button>
        </div>";
        $year=$year-'0';
        $fevrier=28;
        if (Times::bissextile($year)) {$fevrier=29;}
        $months=array(31,$fevrier,31,30,31,30,31,31,30,31,30,31);
        echo "<table class='calendar'>";
        for ($i=0;$i<12;$i++){
            echo "<tr class='month_".($i+1)."'>";
            for ($j=1;$j<=$months[$i];$j++){
                $m=Utility::getRealNumber($i+1);
                $d=Utility::getRealNumber($j);
                $this->showDay($d,$m,$year,$teletravail);
                if ($j %7 ==0) {echo "</tr><tr class='month_".($i+1)."'>";}
            }
            echo "</tr>";
        }
        echo "</table>
            <div class='manager_month'>
                <button onclick='nextMonth()'>&#9654;</button>
            </div>";
        if (!$teletravail) {
            echo "
            <footer class='legendePlanning'>
            <h4>Légende</h4>
            <span class='legend daily'></span><span>Daily</span><br>
            <span class='legend non-working-day'></span><span>Jours non travaillés</span><br>
            <span class='legend environnement'></span><span>Problèmes d'environnement</span><br>
            <span class='legend task'></span><span>Ticket</span><br>
            </footer>";
            $activeVar="isActive";
        }
        else {
            $activeVar="isActiveTT";
        }
        echo "
            <script>
                initMonth();
                $activeVar=true;
            </script>
        ";
    }
}
?>
