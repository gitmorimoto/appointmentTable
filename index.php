<?php
include('config.php');
$allClientData = glob($pathToClientData.'/*.*');
$listSize = count($allClientData);

?>
<html>
<header>
    <style>
        .inp{background:darkgreen;color:white;cursor:text}
    </style>
</header>
<body id="" style="height:fit-content;background:black;color:white;position:relative">
    <div id="" class =""  style="width:100%;height:50px;border:1px solid white;display:flex;border:1px solid blue" >
        <button id="clients" class="clients" 
        style="width:100px;height:50px;border-round:10px;border:1px solid white;margin-left:5%">登録者</button>
        <button id="reservedClients" class="clients" 
        style="width:100px;height:50px;border-round:10px;border:1px solid white;margin-left:5%">予約済み登録者</button>
        <button id="appoint" class="btn" 
        style="width:100px;height:50px;border-round:10px;border:1px solid white;margin-left:70%">予約</button>
    </div>
    <div id="mid" style="width:100%;height:100%;display:flex;border:1px solid red;poisiton:relative">
        <div id="mc0" class="" style="width:15%;height:100%;border:1px solid green">
            <div id="" class="" style="width:100%;height:100%;border-right:1px solid white;overflow-y:scroll">
                <?php
                for($i=0;$i<$listSize;$i++){
                    echo '<div id="li'.$i.'" class="li" 
                    style="width:100%;height:30px;font-size:12px;border-bottom:1px solid white"></div>';
                }
                ?>
            </div>
            
        </div><!--end of mc0----------------------->
        <div id="mc1" class="" style="width:85%;height:600px;border:1px solid white;position:relative;border:1px solid orange">
            <div id="idBox" style="width:250px;height:40px;position:absolute;top:5px;left:10px;display:flex">
                ID:<input id="inp0" class ="inp" style="width:150px;height:30px;border:;font-size:21px">
                <button id="searchById" class ="searchById" style="width:100px;height:30px;border-round:10px;border:1px solid white;">検索</button>
            </div>
            
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:5px;left:300px">
                患者氏名:<input id="inp1" class="inp" style="width:200px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:5px;left:600px">
                性別:<input id="inp2" class="inp" style="width:50px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:5px;left:700px">
                出生年月日:<input id="inp3" class="inp" style="width:150px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:5px;left:950px">
                年齢:<input id="inp4" class="inp" style="width:50px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:40px;left:10px">
                保護者氏名:<input id="inp5" class="inp" style="width:200px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:40px;left:300px">
                郵便番号:<input id="inp6" class="inp" style="width:200px;height:30px;border:;font-size:21px">
            </div> 
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:40px;left:600px">
                住所:<input id="inp7" class="inp" style="width:200px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:80px;left:10px">
                電話番号:<input id="inp8" class="inp" style="width:150px;height:30px;border:;font-size:21px">
            </div> 
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:80px;left:250px">
                電話番号:<input id="inp9" class="inp" style="width:150px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:80px;left:500px">
                e-mail:<input id="inp10" class="inp" style="width:150px;height:30px;border:;font-size:21px">
            </div>   
            <div id="" style="width:fit-content;height:fit-content;position:absolute;top:80px;left:750px">
                fax:<input id="inp11" class="inp" style="width:150px;height:30px;border:;font-size:21px">
            </div>
            <div id="" style="width:98%;height:fit-content;position:absolute;top:120px;left:10px;">
                <textarea id="inp12" class="inp" cols="40" rows="20" style="width:100%;height:350px;border:;font-size:21px"></textarea>
            </div>
            <button id="clearBtn" class="btn"  style="width:100px;height:50px;border-round:10px;border:1px solid white;position:absolute;top:480px;left:80%;">clear</button>
        </div><!--end of mc1----------------------->
    </div><!--end of mid----------------------->
        <script>
        document.addEventListener('DOMContentLoaded', () => {
        ///////////////variables//////////////////////////////
        const appointObj = document.getElementById('appoint');
        let inpObj = [];
        const inpArray = [];
        const clientsObj = document.getElementById('clients');
        let allClients = [];
        let liObj = [];
        
        ////////////////////////construct parameters/////////////
        /*
         const cData = ['111','日本太郎','男','1982-03-08','43'
         ,'日本一','798-1322','愛媛県北宇和郡','090-1322-7629',
         '','089-799-1333','xxx@.gmail.com','This is a test comment.'];
        for(let i=0;i<13;i++)
            {
                inpObj[i] = document.getElementById('inp'+i);
                //console.log('inpObj['+i+']='+inpObj[i])
                //inpObj[i].value = 'inp'+i;
                inpObj[i].value = cData[i];
            }
            */
        /////////////////////////////////////////////////////////////////
        const reservedClientsObj = document.getElementById('reservedClients');
        /////////////////////////////////////////////////////////////////////
        fetch('getClientData.php')//cliet data serched by ID
        .then(res=>{
            if(!res.ok){
                throw new Error('net work error')
            }
            return res.json()
        })
        .then(data=>{
            //console.log(data);
 
            for(let i=0;i<13;i++)
            {
                inpObj[i] = document.getElementById('inp'+i);
                //console.log('inpObj['+i+']='+inpObj[i]);
                switch(i){
                    case 0:
                        inpObj[0].value = data[0];
                        break;
                    case 1:
                        inpObj[1].value = data[2]+data[4];
                        break;
                    case 2:
                        inpObj[2].value = data[5];
                        break;
                    case 3:
                        inpObj[3].value = data[6];
                        break;
                    case 4:
                        inpObj[4].value = "";
                        break;
                    case 5:
                        inpObj[5].value = data[8];
                        break;
                    case 6:
                        inpObj[6].value = data[7];
                        break;
                    case 7:
                        inpObj[7].value = data[8];
                        break;
                    case 12:
                        inpObj[12].value = data[9];
                        break;
                    default :
                        break;
                   
                }
                
                
            }
        })
        .catch(error=>{
            console.error(error)
        })
      //////////////////////////////////////////////////////////////////
      clientsObj.addEventListener('click',function(){
            clientsObj.style.background = "orange";
            fetch('getAllClientsData.php')// all cliet data are gathered.
            .then(res=>{
                if(!res.ok){
                    throw new Error('net work error')
                }
                return res.json()
            })
            .then(data=>{
                console.log(data);
                let i=0;
                data.forEach(e=>{
                    console.log(e);
                    liObj[i] = document.getElementById('li'+i);
                    liObj[i].textContent = e[0]+'/'+e[1];
                    liObj[i].addEventListener('click',function(){
                        for(let j=0;j<13;j++)
                        {
                            inpObj[j] = document.getElementById('inp'+j);
                            switch(j){
                                case 0:
                                    inpObj[0].value = e[0]
                                    break;
                                case 1:
                                    inpObj[1].value = e[1]
                                    break;
                                case 2:
                                    inpObj[2].value = e[2]
                                    break;
                                case 3:
                                    inpObj[3].value = e[3]
                                    break;
                                case 4:
                                    inpObj[4].value =""
                                    break;
                                case 5:
                                    inpObj[5].value = ""
                                    break;
                                case 6:
                                    inpObj[6].value = e[4]
                                    break;
                                case 7:
                                    inpObj[7].value = e[5]
                                    break;
                                default:
                                    break;
                            }
                        }
                    })
                    i++;
                })
    
                
            })
            .catch(error=>{
                console.error(error)
            })

      })  


        const searchByIdObj = document.getElementById('searchById');
        searchByIdObj.addEventListener('click', () => {
            
            searchByIdObj.style.background = "orange";
            let id = inpObj[0].value;
            console.log('id='+id);
            fetch('getInpData.php',{
                method:'POST',
                //headers:{'Content-Type':'application/json'},
                body:id
            })
            .then(res=>{
                if(!res.ok)
                {
                    throw new Error('net work error')
                }
                return res.json()
            })
            .then(data=>{
                console.log(data);
                for(let i=0;i<data.length;i++){
                    console.log(data[i]);
                    if(data[i][0]==="remote"){
                        //['1762574227', '666', 'もりもと', '森本', 'たけひこ', '武彦', '男', '1952-02-17', '798-1322', '愛媛県北宇和郡鬼北町上川', '\n  test          ']
                        console.log(data[i][1]);
                        for(let j=0;j<13;j++){
                            inpObj[j] = document.getElementById('inp'+j);
                            switch(j){
                                case 0://id
                                    inpObj[0].value = data[i][1][1];
                                    break;
                                case 1://name
                                    inpObj[1].value = data[i][1][3]+data[i][1][5];
                                    break;
                                case 2://gender
                                    inpObj[2].value = data[i][1][6];
                                    break;
                                case 3://birth day
                                    inpObj[3].value = data[i][1][7];
                                    break;
                                case 4://age
                                    inpObj[6].value = "";
                                    break;
                                case 5://parent
                                    inpObj[5].value = "";
                                    break;
                                case 6://post number
                                    inpObj[6].value = data[i][1][8];
                                    //inpObj[6].value = "post number";
                                    break;
                                case 7://address
                                    inpObj[7].value = data[i][1][9];
                                    //inpObj[7].value = "address";
                                    break;
                                case 8://tel
                                    inpObj[8].value = "";
                                    break;
                                case 9://tel
                                    inpObj[9].value = "";
                                    break;
                                case 10://email
                                    inpObj[10].value = "";
                                    break;
                                case 11://fax
                                    inpObj[11].value = "";
                                    break;
                                case 12://comment
                                    inpObj[12].value = "";
                                    break;
                                default:
                                    break;
                            }
                        }
                    }else if(data[i][0]==="gotoClientManager"){
                        //console.log('gotoClientManager ok');
                        location.href = "http://localhost/myAppli/docMaker/clientManager-Prototype/index.php";
                    }else{ 
                        console.log(data[i]);
                        
                        console.log('data['+i+']='+data[i]);
                        //1767409021,111,inp1,inp2,inp3,inp4,inp5,inp6,inp7,inp8,inp9,inp10,inp11,This is test
                        data.forEach(e=>{
                            console.log(e);
                            let selCase = [];
                            let date = new Date(e[0]*1000);
                            let year = date.getFullYear();
                            let month = date.getMonth()+1;
                            let day = date.getDate();
                            console.log(e[1]);
                            //['111', 'inp1', 'inp2', 'inp3', 'inp4', 'inp5', 'inp6', 'inp7', 'inp8', 'inp9', 'inp10', 'inp11', 'This is test 1b.']
                            liObj = document.querySelectorAll('.li');
                            liObj[i].textContent = year + '年' + month + '月' + day + '日';
                            liObj[i].addEventListener('click',function(){
                                console.log(e[1]);
                                selCase = e[1];
                                for(let j=0;j<selCase.length;j++){
                                    inpObj[j] = document.getElementById('inp'+j);
                                    inpObj[j].value = selCase[j];
                                }
                            })
                            i++;
                        })
                    }
                }
            })
            .catch(error=>{
                console.error(error);
            })
                
        })     
        appointObj.addEventListener('click',function(){
            for(let i=0;i<13;i++)
            {
                //const inpObj[i] = document.getElementById('inp'+i);
                inpArray[i] = inpObj[i].value;
            }
            console.log(inpArray);
            fetch('book.php',{
                method:'POST',
                headers:{'Content-Type':'application/json'},
                body:JSON.stringify(inpArray)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("ネットワークのエラーが発生しました");
                }
                return response.text();
            })
            .then(data => {
                console.log(data);
                location.href="appoBook.php";
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        })

    reservedClientsObj.addEventListener('click',function(){
        reservedClientsObj.style.background = "orange";
        fetch('getReservedClientsData.php')
        .then(res=>{
                if(!res.ok){
                    throw new Error('net work error')
                }
                return res.json()
            })
            .then(data=>{
                console.log(data);
                let i=0;
                
                data.forEach(e=>{
                    console.log('e='+e);
                    
                    liObj[i] = document.getElementById('li'+i);
                    liObj[i].textContent = e[0]+'/'+e[1]+'/'+e[13];
                    liObj[i].addEventListener('click',function(){
                        for(let j=0;j<13;j++)
                        {
                            inpObj[j] = document.getElementById('inp'+j);
                            switch(j){
                                case 0:
                                    inpObj[0].value = e[0]
                                    break;
                                case 1:
                                    inpObj[1].value = e[1]
                                    break;
                                case 2:
                                    inpObj[2].value = e[2]
                                    break;
                                case 3:
                                    inpObj[3].value = e[3]
                                    break;
                                case 4:
                                    inpObj[4].value =""
                                    break;
                                case 5:
                                    inpObj[5].value = ""
                                    break;
                                case 6:
                                    inpObj[6].value = e[4]
                                    break;
                                case 7:
                                    inpObj[7].value = e[5]
                                    break;
                                default:
                                    break;
                            }
                        }
                    })
                    i++;
                    
                })
    
                
            })
            .catch(error=>{
                console.error(error)
            })


    })
 
 //////////////////////////////////clear data//////////////////////////////////////////////////
const clearObj = document.getElementById('clearBtn');
console.log(clearObj);
clearObj.addEventListener('click',function(){
    clearObj.style.background = "orange";
    inpObj = document.querySelectorAll('.inp');
    for(let i=0;i<13;i++)
    {
        inpObj[i] = document.getElementById('inp'+i);
        console.log(inpObj[i]);
        inpObj[i].value = "";
    }
})
})
    </script>
</boby>
</html>
