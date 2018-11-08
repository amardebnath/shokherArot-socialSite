var start=0;
var end=9;
$( document ).ready(function() {
    var username = document.getElementById('user').innerHTML;
    var postbox = document.getElementById('postbox');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var string = this.responseText;
            var success = string.charAt(string.length-1);
            string = string.substring(0, string.length-1);
            var t1 = postbox.innerHTML;
            postbox.innerHTML = t1+string;
            start = start + parseInt(success, 10);
            end = start+9;
        }
    };
    xmlhttp.open("GET", "profileResponse.php?q=load&username="+username.toString()+"&start="+start.toString()+"&end="+end.toString(), true);
    xmlhttp.send();
}); 

function loadmore(element) {
    var username = document.getElementById('user').innerHTML;
    var postbox = document.getElementById('postbox');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var string = this.responseText;
            var success = string.charAt(string.length-1);
            string = string.substring(0, string.length-1);
            var t1 = postbox.innerHTML;
            postbox.innerHTML = t1+string;
            start = start + parseInt(success, 10);
            end = start+9;
        }
    };
    xmlhttp.open("GET", "profileResponse.php?q=load&username="+username.toString()+"&start="+start.toString()+"&end="+end.toString(), true);
    xmlhttp.send();
}

function loadPost(element) {
    var postid = element.id;
    window.location='postPage.php?postid='+postid.toString();
}

function show(element){
    var temp = element.getElementsByTagName("SPAN");
    temp[0].style.opacity=1;
}
function notShow(element){
    var temp = element.getElementsByTagName("SPAN");
    temp[0].style.opacity=0;
}

function deletee(element, postid){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Post Deleted.");
            window.location ='profile.php?username=' + this.responseText;
        }
    };
    xmlhttp.open("GET", "profileResponse.php?q=delete"+"&postid="+postid.toString(), true);
    xmlhttp.send();
}

var settingsmodal = document.getElementById('settingsModal');
var b = document.getElementById("settingsbutton");

var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");

btn.onclick = function() {
    modal.style.display = "block";
} 
b.onclick = function() {
    settingsmodal.style.display = "block";
}



window.onclick = function(event) {
    if (event.target == settingsmodal) {
        settingsmodal.style.display = "none";
    }
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var modal = document.getElementById('myModal');

var btn = document.getElementById("myBtn");


btn.onclick = function() {
    modal.style.display = "block";
}

function edit(){
    window.location = 'settings.php';
}

function logout(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            window.location = 'signin.php';
        }
    };
    xmlhttp.open("GET", "profileResponse.php?q=logout", true);
    xmlhttp.send();
}