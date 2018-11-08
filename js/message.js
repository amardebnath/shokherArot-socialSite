var receiver="none";
function loadMessage(element)
{
    var box = document.getElementById('msgbox');
    var username = element.id;
    element.style.backgroundColor='lightgray';
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var string = this.responseText;
            var t1 = box.innerHTML;
            box.innerHTML = string;
            element.style.backgroundColor='lightgray';
            receiver = username;
            box.scrollTop = box.scrollHeight;
        }
    };
    xmlhttp.open("GET", "messageResponse.php?q=loadmessage&username="+username.toString(), true);
    xmlhttp.send();
}

function sendMessage(event, element){
    if(event.keyCode==13 ){
       if(receiver=="none") alert('No User selected');
        else{
            var box = document.getElementById('msgbox');
            var msg = element.value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var t1 = box.innerHTML;
                    var t2 = this.responseText;
                    box.innerHTML = t1+t2;
                    element.value="";
                    box.scrollTop = box.scrollHeight;
                }
            };
            xmlhttp.open("GET", "messageResponse.php?q=sendmessage&username="+receiver.toString()+"&message=" + msg.toString(), true);
            xmlhttp.send();

        }     
    }
}
