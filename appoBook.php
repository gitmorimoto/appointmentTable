<?php
include('class.Calendar.php');
$currentReserve = [];
$res = [];
$state = [];
$paths = glob('dataCenter/appoStore/*.json');
//print_r($paths);echo '<br>';
for($i=0;$i<count($paths);$i++)
{
    $date = explode('/',$paths[$i]);
    $date = end($date);
    $date = explode('.',$date)[0];
    //echo $date;echo '<br>';
    $currentReserve[$i] = json_decode(file_get_contents($paths[$i]),true);
    //print_r($currentReserve[$i]);echo '<br><br><br><br>';
    $res[$date] = $currentReserve[$i];
    
}
//print_r($res);
foreach($res as $k=>$v)
{
    $state[$k] = [];
    //echo 'key='.$k;echo '<br>';
    //print_r($v);echo '<br>';
    foreach($v as $data)
    {
        //echo "data=";
        //print_r($data);echo '<br>';
       // print_r($data[0][0]);echo '<br>';
       // print_r($data[0][1]);echo '<br>';
        //echo $data[0][1];echo '<br>';
        //echo $data[0][0];echo '<br>';
        $id = $data[0][0];
        //echo $data[0][1];echo '<br>';
        $name = $data[0][1];
        if($id && $name)
        {
            array_push($state[$k],1);
        }else{
            array_push($state[$k],0);
        }
    }
        
}
//var_dump($state);
file_put_contents('state.json',json_encode($state,JSON_UNESCAPED_UNICODE));
//echo 'ok';
$obj = new Calendar();
//print_r($currentReserve);

if(file_exists('yM.json') && file_get_contents('yM.json'))
{
    $sender = json_decode(file_get_contents('yM.json'),true);
}else{
    $sender = [2026,1];
}
/*
//print_r($sender);
$day = json_decode(file_get_contents('dataCenter/selDay.json'),true);
$path = 'dataCenter/appoStore/'.$day[0].'_'.$day[1].'_'.$day[2].'.json';
echo $path;echo '<br>';
$registeredData = json_decode(file_get_contents($path),true);

//print_r($registeredData);
*/
/*
for($i=0;$i<count($currentReserve);$i++)
{
    if($currentReserve[$i][0][0]&&$currentReserve[$i][0][0])
    {
        echo $i;echo '<br>';
        echo $currentReserve[$i][0][0];echo '<br>';
        echo $currentReserve[$i][0][1];echo '<br>';
        $currentReserve[$i] = 1;
        
    }else{
        $currentReserve[$i] = 0;
    }
}
print_r($currentReserve);
file_put_contents('currentState.json',json_encode($currentReserve));
$obj = new Calendar();
$dataArray = json_decode(file_get_contents('dataCenter/dataArray.json'),true);
//print_r($dataArray);
//print_r($sender);
*/
?>
<html>
<header>
    <style>
        body{background:black;color:white}
    </style>
</header>
<body id="body">
    <input id="sY" type="" value="<?php echo $sender[0];?>">
    <input id="sM" type="" value="<?php echo $sender[1];?>">
    <div id="" class="" style = "display:flex">
        <button id="inpBox" class=""　style="width:800px;height:40px;border-round:10px">入力画面</button>
        <input id="selY" type="number" style="width:100px;height:40px;background:darkgreen;color:white;font-size:21px" min="2026">
        年
        <input id="selM" type="number" style="width:100px;height:40px;background:darkgreen;color:white;font-size:21px" min="1">
        月
        <button id="currentCondition" class="" style="width:80px;height:40px;border-round:10px">予約状況確認</button>
        <button id="dataSheet" class="" style="width:80px;height:40px;border-round:10px;margin-left:10px">印刷</button>

    </div>
    <div id="" class ="" style="width:90%;height:800px;border:;display:flex">
        <div id="" class ="" style="width:30%;height:98%;border:1px solid white;margin:5px">
            <?php
                
                $obj->makeMonth($sender[0],$sender[1]);
            ?>
        </div>
        <div id="" class ="" style="width:30%;height:98%;border:1px solid white;margin:5px;display:">
            <?php
                $nM1 = $sender[1]+1;
                
                if($nM1>12)
                {
                    $nM1=$nM1-12;
                    $nY1=$sender[0]+1;
                    
                }else{
                    $nY1=$sender[0];
                }
                $obj->makeMonth($nY1,$nM1);
                
            ?>
        </div>
        <div id="" class ="" style="width:30%;height:98%;border:1px solid white;margin:5px;display:">
            <?php
                $nM2 = $sender[1]+2;
                if($nM2>12)
                {
                    $nM2=$nM2-12;
                    $nY2=$sender[0]+1;
                    
                }else{
                    $nY2=$sender[0];
                }
                $obj->makeMonth($nY2,$nM2);
                
            ?>
        </div>

    </div>
<script>
    let stateObj = [];
    const selYObj = document.getElementById('selY');
    const selMObj = document.getElementById('selM');
    appoObj = document.querySelectorAll('.appo');
    dataSheetObj = document.getElementById('dataSheet');
    
    appoObj.forEach(el => {
        el.style.color = "transparent";
    });
    const unitObj = document.querySelectorAll('.unit');
    unitObj.forEach(el => {
        el.addEventListener('click',function(){
            //console.log(el);
            let id=el.id;
            //console.log(id);
            //console.log(id.substr(4));
            let day = id.substr(4);
            //day = '2026_01_05';
            //console.log(day);
            fetch('makeAppo.php',{
                method:'POST',
                //headers:{'Content-Type':'application/json'},
                body:day
            })
            .then(response=>{
                if(!response.ok){
                    throw new Error('net work error');
                }
                return response.text();
            })
            .then(data=>{
                //console.log(data);
                location.href="makeUnitByDay.php";
            })
            .catch(error=>{
                console.error(error);
            })
        })
    })
const inpBoxObj = document.getElementById('inpBox');
inpBoxObj.addEventListener('click',function(){
    location.href="index.php";
})
/////////////////input year and month///////////////////
let sY = 0;
let sM = 0;
selYObj.addEventListener('mouseleave',function(){
    sY = selYObj.value;
    //console.log('sY='+sY);
})
selMObj.addEventListener('mouseleave',function(){
    sM = selMObj.value;
    //console.log('sM='+sM);
    if(sY!=0 && sM!=0)
    {
        let sender = [sY,sM];
        //console.log('sender='+sender);
        fetch("changeYM.php",{
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify(sender)
        })
        .then(res=>{
            if(!res.ok)
            {
                throw new Error('network error')
            }
            return res.json()
        })
        .then(data=>{
           // console.log(data);
            location.reload();
        })
    }
})
/////////////////////display reservation////////////////////////
//const currentConditionObj = document.getElementById('currentCondition');
const idNumObj = [];
const nameObj = [];
currentCondition();
function currentCondition()
{
//currentConditionObj.addEventListener('click',function(){
    //.log('state0');
    fetch('getCurrentState.php')
    .then(res=>{
        if(!res.ok)
        {
            throw new Error('network error')
        }
        return res.json()
    })
    .then(data=>{
        //console.log('state1');
        //console.log(data);
        Object.keys(data).forEach(key => {
           // console.log(`${key}: ${data[key]}`);
            for(let i=0;i<data[key].length;i++)
            {
                //.log('appo'+key+'_'+i);
                stateObj[key+'_'+i] = document.getElementById('appo'+key+'_'+i);
                stateObj[key+'_'+i].style.display="block";
                stateObj[key+'_'+i].style.color="transparent";

                //console.log('state='+data[key][1]);
                if(data[key][i]==1)
                {
                    stateObj[key+'_'+i].style.background = "red";
                }
            
            
            }
        
        });
        
    })
}



let ymdArray = document.querySelectorAll('.ymd');
//console.log('ymdArray='+ymdArray);
let dObj = [];
ymdArray.forEach((e,index)=>{
    //console.log(e);
    //console.log('index='+index);
    //console.log(ymdArray[index]);
    ymdArray[index].addEventListener('click',function(){
        let selDaysArray = [];
        ymdArray = document.querySelectorAll('.ymd');
        ymdArray[index].style.border = '5px solid red';
        ymdArray[index+1].style.border = "5px solid red";
        ymdArray[index+2].style.border = "5px solid red";
        ymdArray[index+3].style.border = "5px solid red";
        ymdArray[index+4].style.border = "5px solid red";
        ymdArray[index+5].style.border = "5px solid red";
        ymdArray[index+6].style.border = "5px solid red";
        
        selDaysArray.push(ymdArray[index].id.replace('ymd',''));
        selDaysArray.push(ymdArray[index+1].id.replace('ymd',''));
        selDaysArray.push(ymdArray[index+2].id.replace('ymd',''));
        selDaysArray.push(ymdArray[index+3].id.replace('ymd',''));
        selDaysArray.push(ymdArray[index+4].id.replace('ymd',''));
        selDaysArray.push(ymdArray[index+5].id.replace('ymd',''));
        selDaysArray.push(ymdArray[index+6].id.replace('ymd',''));
        console.log(selDaysArray);
        fetch('selectedDays.php',{
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify(selDaysArray)
        })
        .then(res=>{
            if(!res.ok)
            {
                throw new Error('network error')
            }
            return res.text()
        })
        .then(data=>{
            console.log(data);
            location.href="printSheet.php"
        })



        dataSheetObj.addEventListener('click',function(){
            dataSheetObj.style.background = "orange";

        })
    })
})
   // appo'.$y.'_'.$m.'_'.$d.'_'.$i.
   /*
    const sYObj = document.getElementById('sY');
    const sMObj = document.getElementById('sM');
    let sY = sYObj.value;
    let sM = sMObj.value;
    sY = Number(sY.trim());
    sM = Number(sM.trim());
    let moSize = 31;
    for(let d=1;d<moSize;d++)
    {
        console.log('d='+d);
        
        for(let s=0;s<36;s++)
        { 
            
            console.log('number'+sY+'_'+sM+'_'+d+'_'+s);
            //console.log(document.getElementById('appo'+sY+'_'+sM+'_'+d+'_'+s));
            if(document.getElementById('number'+sY+'_'+sM+'_'+d+'_'+s))
            {
                let k = sY+'/'+sM+'/'+d+'/'+s;
                console.log('k='+sY+'/'+sM+'/'+d+'/'+s);
                //appoObj[k] = document.getElementById('appo'+sY+'_'+sM+'_'+d+'_'+s);
                //console.log(appoObj[k]) ;
                idNumObj[k] = document.getElementById('number'+sY+'_'+sM+'_'+d+'_'+s);
                nameObj[k] = document.getElementById('name'+sY+'_'+sM+'_'+d+'_'+s);
                console.log(idNumObj[k].textContent);
                console.log(nameObj[k].textContent);
                
                
            }
            
        
        }
        
    }
    */    



/*
'<div id="appo'.$y.'_'.$m.'_'.$d.'_'.$i.'" class="appo"
'<div id="number'.$y.'_'.$m.'_'.$d.'_'.$i.'" class="number" style="width:100%;height:25%;font-size:9px">';
                        
echo '</div>';
echo '<div id="name'.$y.'_'.$m.'_'.$d.'_'.$i.'" class="name" style="width:100%;height:25%;font-size:9px">';
                        
echo '</div>';
*/
</script>
</body>
</heml>   