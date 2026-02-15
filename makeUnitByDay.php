<?php
include('class.Unit.php');
$uObj=new Unit();
$day = json_decode(file_get_contents('dataCenter/selDay.json'),true);
$selPath = $day[0].'_'.$day[1].'_'.$day[2].'.json';
echo $selPath;
?>
<html>
<header>
</header>
<body id="body" style="background:" >
    <input id="selectedPath" type="hidden" value="<?php echo $selPath; ?>">;
    <div id="top" style="width:100%;height:30px;display:flex;background:black">
        <button id="store" style="width:80px;height:30px;border-round:10px">登録</button>
        <button id="enlarge" style="width:80px;height:30px;border-round:10px">拡大</button>
        <button id="forward" style="width:80px;height:30px;border-round:10px">戻る</button>
        <button id="print" style="width:80px;height:30px;border-round:10px">印刷</button>
    </div>
    
    <?php
    echo '<div id="ymd" style="width:100%;height:30px;display:flex;background:;color:white;margin-left:40%">'.$day[0].'年'.$day[1].'月'.$day[2].'日</div>';
    echo '<div id="main" style="width:210mm;height:290mm;border:">';
    $uObj->makeUnit($day[0],$day[1],$day[2]);
    echo '</div>';
    ?>
<!--///////////////////SCRIPT///////////////////////////////////-->
<script>
let topObj = document.getElementById('top');
let mainObj = document.getElementById('main');
let ymdObj = document.getElementById('ymd');
let bodyObj = document.getElementById('body');
let uObj = document.querySelectorAll('.u');
let appoObj = document.querySelectorAll('.appo');
appoObj.forEach(ap=>{
    ap.style.borderBottom = "1px solid white";
})

let  clientObj = document.querySelectorAll('.client');
let comObj = document.querySelectorAll('.com');
const yearMonthObj = document.getElementById('yearMonth');
const caseObj = document.querySelectorAll('.case');


selDayObj = document.getElementById('selDay');
const selDay = selDayObj.value;


bodyObj.style.background = "black";
uObj.forEach(e=>{
    e.style.background = "black";
    e.style.color = "white";
    e.style.border = "1px solid white";
})


//console.log(selDay);
fetch('getSelData.php',{
    method:'POST',
    //headers:'Content-Type':'application/json',
    body:selDay
})
.then(res=>{
    if(!res.ok)
    {
        throw new Error('net work error');
    }
    return res.json();
})
.then(data=>{
    let client = [];
    let comment = [];
    let numberObj = [];
    let nameObj = [];
    let sexObj = [];
    let ageObj = [];
    
   
    for(let i=0;i<clientObj.length;i++)
    {
        numberObj[i] = clientObj[i].querySelector('.number');
        nameObj[i] = clientObj[i].querySelector('.name');
        sexObj[i] = clientObj[i].querySelector('.sex');
        ageObj[i] = clientObj[i].querySelector('.age');
        if(data.length!==0)
        {
            numberObj[i].textContent = data[i][0][0];
            nameObj[i].textContent = data[i][0][1];
            sexObj[i].textContent = data[i][0][2];
            ageObj[i].textContent = data[i][0][3];
            //console.log(numberObj[i].textContent);
            comObj[i].textContent = data[i][1];
            
        }else{
            numberObj[i].textContent = "";
            nameObj[i].textContent = "";
            sexObj[i].textContent = "";
            ageObj[i].textContent = "";
            comObj[i].textContent = "";
        }
        
    }
    
    /*
    console.log(numberObj);
    console.log(nameObj);
    console.log(sexObj);
    console.log(ageObj);
    */
})
.catch(error=>{
    console.error(error);
})


//console.log(idObj);
//console.log(idObj.length);
//console.log('caseObj='+caseObj);
appoObj.forEach(e=>{
    //console.log(e);
    
    e.addEventListener('click',function(){
        // e.style.background = "orange";
         console.log(e.id);
         let appoId = e.id;
        //console.log('selUnit');
        fetch('getCase.php')
        .then(res=>{
            if(!res.ok)
            {
                throw new Errow('net work error')
                
            }
            return res.json()
        })
        .then(data=>{
            console.log(data);
            //console.log(e);
            let numberObj = [];
            let nameObj = [];
            let sexObj = [];
            let ageObj = [];
           // let comObj = [];
            //let i=0;
            clientObj = e.querySelectorAll('.client');
                console.log(clientObj);
                clientObj.forEach(cl=>{
                    //console.log(cl);
                    numberObj = cl.querySelectorAll('.number');
                    nameObj = cl.querySelectorAll('.name');
                    sexObj = cl.querySelectorAll('.sex');
                    ageObj = cl.querySelectorAll('.age');
                    
                })
                comObj = e.querySelectorAll('.com');
                let j=0;
                numberObj.forEach(num=>{
                    num.textContent = data[0];
                    j++;
                })
                let k=0;
                nameObj.forEach(nam=>{
                    nam.textContent = data[1];
                    k++;
                })
                let l=0;
                sexObj.forEach(sex=>{
                    sex.textContent = data[2];
                    l++;
                })
                let m=0;
                ageObj.forEach(age=>{
                    age.textContent = data[3];
                    m++;
                })
                comObj.forEach(c=>{
                c.textContent = data[4];
            })
           // i++;
            document.addEventListener('keyup',k=>{
                console.log(appoId);
                caseId = appoId.replace('appo','case');
                console.log(caseId);
                clientId = appoId.replace('appo','client');
                console.log(clientId);
                nameId = appoId.replace('appo','name');
                console.log(nameId);
                numberId = appoId.replace('appo','number');
                sexId = appoId.replace('appo','sex');
                ageId = appoId.replace('appo','age');
                comId = appoId.replace('appo','com');

                sAppoObj = document.getElementById(appoId);
                console.log(sAppoObj);
                sCaseObj = document.getElementById(caseId);
                console.log(sCaseObj);
                sClientObj = document.getElementById(clientId);
                console.log(sClientObj);
                sNameObj = document.getElementById(nameId);
                console.log(sNameObj);
                sNameObj.textContent = "";
                sNumberObj = document.getElementById(numberId);
                console.log(sNumberObj);
                sNumberObj.textContent = "";
                sNumberObj = document.getElementById(numberId);
                console.log(sNumberObj);
                sNumberObj.textContent = "";
                sSexObj = document.getElementById(sexId);
                console.log(sSexObj);
                sSexObj.textContent = "";
                sAgeObj = document.getElementById(ageId);
                console.log(sAgeObj);
                sAgeObj.textContent = "";
                sComObj = document.getElementById(comId);
                console.log(sComObj);
                sComObj.textContent = "";
               
            })


            
            
           // e.textContent = data[0]+'　'+data[1]+'　'+data[2]+'　'+data[3]+'/'+data[4];
            
            
        })
        .catch(error=>{
            console.error(error)
        })
       
    })
})

const storeObj = document.getElementById('store');
storeObj.addEventListener('click',function(){
    storeObj.style.background = "orange";
    const appoDataArray = [];
    let sender = [];
    //console.log(yearMonthObj);
    const yM = yearMonthObj.textContent;
    caseObj.forEach(e=>{
        //console.log(e);
        clientObj = e.querySelectorAll('.client');
        comObj = e.querySelectorAll('.com');
        console.log(clientObj);
        clientObj.forEach(cl=>{
            numberObj = cl.querySelectorAll('.number');
            nameObj = cl.querySelectorAll('.name');
            sexObj = cl.querySelectorAll('.sex');
            ageObj = cl.querySelectorAll('.age');
            numberObj = Array.from(numberObj);
            nameObj = Array.from(nameObj);
            sexObj = Array.from(sexObj);
            ageObj = Array.from(ageObj);
            // = Array.from(comObj);
            console.log(numberObj);
            console.log(nameObj);
        })

        let number = numberObj[0].textContent;
        let name = nameObj[0].textContent;
        let sex = sexObj[0].textContent;
        let age = ageObj[0].textContent;
        let com = comObj[0].textContent;
        let array = [[number,name,sex,age],com];
        console.log(array);
        appoDataArray.push(array);
    })
    console.log(appoDataArray);
    sender=[yM,appoDataArray];
    console.log('yM='+yM);
    fetch('store.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(sender)
    })
    .then(res=>{
        if(!res.ok)
        {
            throw new Error('network error');
        } 
        return res.json();
    })
    .then(data=>{
         console.log(data);
    })
    .catch(error=>{
        console.error(error);
    })
    

})
function enlarge()
{
    let uObj = document.querySelectorAll('.u');
    const amObj = document.querySelectorAll('.am');
    const pmObj = document.querySelectorAll('.pm');
    appoObj = document.querySelectorAll('.appo');
    numberObj = document.querySelectorAll('.number');
    nameObj = document.querySelectorAll('.name');
    sexObj = document.querySelectorAll('.sex');
    ageObj = document.querySelectorAll('.age');
    
   // const comObj = document.querySelectorAll('.com');
    uObj.forEach(e=>{
        e.style.overflowY = "scroll"; 
    })
    amObj.forEach(a=>{
        a.style.height="300%";
    })
    pmObj.forEach(p=>{
        p.style.height="300%";
    })
    appoObj.forEach(ap=>{
        ap.style.height="100px";
    })
    numberObj.forEach(num=>{
        num.style.fontSize="12px";
    })
    nameObj.forEach(nam=>{
        nam.style.fontSize="12px";
    })
    sexObj.forEach(sex=>{
        sex.style.fontSize="12px";
    })
    ageObj.forEach(age=>{
        age.style.fontSize="12px";
    })
    comObj.forEach(c=>{
        c.style.fontSize="12px";
    })
    
}
function small()
{
    uObj = document.querySelectorAll('.u');
    amObj = document.querySelectorAll('.am');
    pmObj = document.querySelectorAll('.pm');
    appoObj = document.querySelectorAll('.appo');
    numberObj = document.querySelectorAll('.number');
    nameObj = document.querySelectorAll('.name');
    sexObj = document.querySelectorAll('.sex');
    ageObj = document.querySelectorAll('.age');
    comObj = document.querySelectorAll('.com');
    
    uObj.forEach(e=>{
        e.style.overflowY = ""; 
    })
   
    amObj.forEach(a=>{
        a.style.height="95%";
    })
    pmObj.forEach(p=>{
        p.style.height="95%";
    })
    appoObj.forEach(ap=>{
        ap.style.height="50px";
    })
    numberObj.forEach(num=>{
        num.style.fontSize="9px";
    })
    nameObj.forEach(nam=>{
        nam.style.fontSize="9px";
    })
    sexObj.forEach(sex=>{
        sex.style.fontSize="9px";
    })
    ageObj.forEach(age=>{
        age.style.fontSize="9px";
    })
    comObj.forEach(c=>{
        c.style.fontSize="9px";
    })
}
const enlObj = document.getElementById('enlarge');
let size = 0;
enlObj.addEventListener('click',function(){
    if(size==0)
    {
        enlObj.style.background = "orange";
        enlarge();
        size=1;
    }else{
        enlObj.style.background = "transparent";
        small();
        size=0;
    }
    

})
const forwardObj = document.getElementById('forward');
forwardObj.addEventListener('click',function(){
    location.href="appoBook.php";
})
const printObj = document.getElementById('print');
printObj.addEventListener('click',function(){
    topObj = document.getElementById('top');
    mainObj = document.getElementById('main');
    ymdObj = document.getElementById('ymd');
    bodyObj = document.getElementById('body');
    uObj = document.querySelectorAll('.u');
    appoObj = document.querySelectorAll('.appo');
    printObj.style.display = "none";
    topObj.style.display = "none";
    bodyObj.style.background = "white";
    bodyObj.style.color = "black";
    mainObj.style.color = "black";
    uObj.forEach(e=>{
        e.style.background = "white";
        e.style.color = "black";
        e.style.border = "1px solid black";
    })
    appoObj.forEach(ap=>{
        ap.style.borderBottom = "1px solid black";
    })
})
///////////////////////////////////////////////////////
selectedPathObj = document.getElementById('selectedPath');
selPath = selectedPathObj.value;
console.log(selPath);
const sDate = selPath.split('.')[0];

fetch('getReservationData.php',{
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body:JSON.stringify(selPath)
})
.then(res=>{
    if(!res.ok)
    {
        throw new Error('network error')
    }
    return res.json()
})
.then(data=>{
    console.log(data);
    data.forEach((e,index)=>{
        console.log(e);
        console.log(index);
        console.log('number'+sDate+'_'+index);
        idObj = document.getElementById('number'+sDate+'_'+index);
        idObj.textContent = e[0][0];
        nameObj = document.getElementById('name'+sDate+'_'+index);
        nameObj.textContent = e[0][1];
        sexObj = document.getElementById('sex'+sDate+'_'+index);
        sexObj.textContent = e[0][2];
        ageObj = document.getElementById('age'+sDate+'_'+index);
        ageObj.textContent = e[0][3];
        comObj = document.getElementById('com'+sDate+'_'+index);
        comObj.textContent = e[1];

    })
})

</script>
</body>
</html>