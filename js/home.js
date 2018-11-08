var start = 0;
var end = 9;

var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
function modalClick(element){
    modal.style.display = "block";
    modalImg.src = element.src;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}

function addComment(event, element, postid){
    if(event.keyCode == 13){
        var cmt = element.value;
        var id = postid.toString();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var t1 = document.getElementById(id).innerHTML;
                var t2 = "<b><a href=profile.php?username=" + this.responseText + ">" + this.responseText + "</a></b> " + cmt + "<br>";
                document.getElementById(id).innerHTML = t1+t2;
                element.value="";
            }
        };
        xmlhttp.open("GET", "homeResponse.php?q=comment&cmt=" + cmt + "&postID=" + id, true);
        xmlhttp.send();
        
    }
}

function like(element, postid){
    var flag;
    if(element.getAttribute('src') == 'images/like.jpg') flag=1; 
    else flag=-1;
    var id = postid.toString() + 'like';
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(flag==1) element.src = 'images/liked.jpg';
            else element.src = 'images/like.jpg';
            
            document.getElementById(id).innerHTML = this.responseText + " Likes";
        }
    };
    xmlhttp.open("GET", "homeResponse.php?q=like&flag=" + flag.toString() + "&postID=" + postid.toString(), true);
    xmlhttp.send();
}

$( document ).ready(function() {
 
    var postbox = document.getElementById('postbox');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var string = this.responseText;
            var success = string.charAt(string.length-5);
            string = string.substring(0, string.length-5);
            var t1 = postbox.innerHTML;
            postbox.innerHTML = t1+string;
            start = start + parseInt(success, 10);
            end = start+4;
        }
    };
    xmlhttp.open("GET", "homeResponse.php?q=load&start="+start.toString()+"&end="+end.toString(), true);
    xmlhttp.send();
}); 

function loadmore(element) {
    
    var postbox = document.getElementById('postbox');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var string = this.responseText;
            var success = string.charAt(string.length-5);
            string = string.substring(0, string.length-5);
            var t1 = postbox.innerHTML;
            postbox.innerHTML = t1+string;
            start = start + parseInt(success, 10);
            end = start+9;
        }
    };
    xmlhttp.open("GET", "homeResponse.php?q=load&start="+start.toString()+"&end="+end.toString(), true);
    xmlhttp.send();
}

function buy(element, postid){
    var flag;
    if(element.getAttribute('src') == 'images/buy.jpg') {
        var id = postid.toString();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                element.src = 'images/bought.jpg';

                alert(this.responseText);
            }
        };
        xmlhttp.open("GET", "homeResponse.php?q=buy&postID=" + postid.toString(), true);
        xmlhttp.send();
    }
}

function bidRequest(element, postid){
    var flag;
    var box = document.getElementById(postid+"bid");
    var textt = document.getElementById(postid+"price");
    if(box.style.display == 'inline') box.style.display = 'none';
    else box.style.display = 'inline';
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            textt.innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "homeResponse.php?q=bidRequest&postID="+postid.toString(), true);
    xmlhttp.send();
}

function bid(event, element, postid){
    if(event.keyCode == 13){
        var price = element.value;
        var id = postid.toString();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.responseText;
                if(res.includes('yes')){
                    alert("Congratulations! you're the highest bidder now.");
                    bidRequest(element, postid);
                }
                else alert("Bidding price not high enough.");
                element.value="";
                element.style.display = 'none';
            }
        };
        xmlhttp.open("GET", "homeResponse.php?q=bid&postID=" + id +"&price=" + price.toString(), true);
        xmlhttp.send();
        
    }
}
