window.onload=function(){
    var imgs=document.querySelectorAll("#thumbnails img");
    for(var i=0;i<5;i++){
        imgs[i].onclick=getchange;
    }
    var featured=document.getElementById("featured");
    featured.onmouseenter=fadei;
    featured.onmouseleave=fadeo;

    function getchange(){
        var a=""+event.srcElement.src;
        var b=a.replace(/small/,"medium");
        featured.innerHTML = "<img src='"+b+"' title='"+event.srcElement.title+"'/>" + "<figcaption>"+event.srcElement.title+"</figcaption>";
    }

    function fadei(){
        var mid=0;
        var begin=setInterval(function(){
            mid+=10;
            document.getElementsByTagName("figcaption")[0].style.opacity=mid/100;
            if(mid>=80)
                clearInterval(begin);
        },125)
    }

    function fadeo(){
        var mid=80;
        var begin=setInterval(function(){
            mid-=10;
            document.getElementsByTagName("figcaption")[0].style.opacity=mid/100;
            if(mid<=0)
                clearInterval(begin);
        },125)
    }

};
