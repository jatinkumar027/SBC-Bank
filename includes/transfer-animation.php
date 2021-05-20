<style>
    .box{
        height: 300px;
        width: 300px;
        background : transparent;
        color: white;
        position: relative;
    }
    .move{
        border-radius: 50%;
        width: 50px;
        height: 50px;
        position: absolute;
        transform: translate(-50%,50%);
        bottom: 0px;
        left : 0px;
        background: linear-gradient(#ED213A, #93291E);;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
    }
</style>

<div class="box">
    <div class="move shadow">
        <i class="fas fa-rupee-sign"></i>
    </div>
    <div class="move shadow">
        <i class="fas fa-rupee-sign"></i>
    </div>
    <div class="move shadow">
        <i class="fas fa-rupee-sign"></i>
    </div>
    <div class="move shadow">
        <i class="fas fa-rupee-sign"></i>
    </div>
    <div class="move shadow">
        <i class="fas fa-rupee-sign"></i>
    </div>
</div>


<script>
        let ball = document.getElementsByClassName('move')

        let interval1
        let x1 = 0;
        let c1 = 1;
        let c2 = 0;
        function moveBall1(){
            let y1 = Math.sqrt(150*150 - (x1-150)*(x1-150))
            ball[0].style.left = x1 + 'px'
            ball[0].style.bottom = y1 + 'px'
            if(c1){
                x1+=5
            ball[0].style.bottom = y1 + 'px'
            }
            else if(c2){
                x1-=5
                ball[0].style.bottom = -y1 + 'px'
            }
            if(x1 >= 300)
            {
                x1 = 0;
                c2 = 0;
                c1 = 1;
            }
            if(x1<=0){
                c1 = 1;
                c2 = 0;
            }
            // console.log(x1 + ', ' + y1)
        }

        
        let interval2 
        let x2 = 0;
        let c3 = 1;
        let c4 = 0;
        function moveBall2(){
            let y2 = Math.sqrt(150*150 - (x2-150)*(x2-150))
            ball[1].style.left = x2 + 'px'
            // ball[1].style.bottom = y2 + 'px'
            if(c3){
                x2+=5
                ball[1].style.bottom = y2 + 'px'
            }
            else if(c4){
                x2-=5
                ball[1].style.bottom = -y2 + 'px'
            }
            if(x2 >= 300)
            {
                x2 = 0;
                c4 = 0;
                c3 = 1;
            }
            if(x2<=0){
                c3 = 1;
                c4 = 0;
            }
            // console.log(x2 + ', ' + y2)
        }

        let interval3 
        let x3 = 0;
        let c5 = 1;
        let c6 = 0;
        function moveBall3(){
            let y3 = Math.sqrt(150*150 - (x3-150)*(x3-150))
            ball[2].style.left = x3 + 'px'
            // ball[1].style.bottom = y2 + 'px'
            if(c5){
                x3+=5
                ball[2].style.bottom = y3 + 'px'
            }
            else if(c6){
                x3-=5
                ball[2].style.bottom = -y3 + 'px'
            }
            if(x3 >= 300)
            {
                x3 = 0;
                c6 = 0;
                c5 = 1;
            }
            if(x3<=0){
                c5 = 1;
                c6 = 0;
            }
            // console.log(x3 + ', ' + y3)
        }

        let interval4 
        let x4 = 0;
        let c7 = 1;
        let c8 = 0;
        function moveBall4(){
            let y4 = Math.sqrt(150*150 - (x4-150)*(x4-150))
            ball[3].style.left = x4 + 'px'
            // ball[1].style.bottom = y2 + 'px'
            if(c7){
                x4+=5
                ball[3].style.bottom = y4 + 'px'
            }
            else if(c8){
                x4-=5
                ball[3].style.bottom = -y4 + 'px'
            }
            if(x4 >= 300)
            {
                x4 = 0;
                c8 = 0;
                c7 = 1;
            }
            if(x4<=0){
                c7 = 1;
                c8 = 0;
            }
            // console.log(x4 + ', ' + y4)
        }

        let interval5 
        let x5 = 0;
        let c9 = 1;
        let c10 = 0;
        function moveBall5(){
            let y5 = Math.sqrt(150*150 - (x5-150)*(x5-150))
            ball[4].style.left = x5 + 'px'
            // ball[1].style.bottom = y2 + 'px'
            if(c9){
                x5+=5
                ball[4].style.bottom = y5 + 'px'
            }
            else if(c9){
                x5-=5
                ball[4].style.bottom = -y5 + 'px'
            }
            if(x5 >= 300)
            {
                x5 = 0;
                c10 = 0;
                c9 = 1;
            }
            if(x5<=0){
                c9 = 1;
                c10 = 0;
            }
            // console.log(x4 + ', ' + y4)
        }

        

        function transactionAnimation(){
            ball[0].style.display = 'flex'
            ball[1].style.display = 'flex'
            ball[2].style.display = 'flex'
            ball[3].style.display = 'flex'
            ball[4].style.display = 'flex'
            setTimeout(()=>{
                interval1 = setInterval(moveBall1, 40);
            }, 500)
            setTimeout(()=>{
                interval2 = setInterval(moveBall2, 40);
            }, 1000)
            setTimeout(()=>{
                interval3 = setInterval(moveBall3, 40);
            }, 1500)
            setTimeout(()=>{
                interval4 = setInterval(moveBall4, 40);
            }, 2000)
            setTimeout(()=>{
                interval5 = setInterval(moveBall5, 40);
            }, 2500)

        }
    </script>