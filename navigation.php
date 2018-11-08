
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/profile1.css">
        <script src="js/jquery-3.3.1.js"></script> 
    
    </head>

    <body style="background-color:#FAFAFA;font-family:Arial;margin:0">
    
        <div class='navbar' >
          <div style="width:80%;margin:auto;">
            <ul>
              <li><a style='padding:0' href='home.php'><img style='width:140px;height:52px;float:left;text-decoration: none;display: inline-block;' src='images/jjjkk.PNG' ></a></li>
                <form style='display:inline-block' action='search.php'><input type='text' name='searchField' placeholder="Search..." class='searchbar'></form>
                <li style="float:right"><a style='padding:0;margin:0;' href='profile.php'><img src='images/profile.jpg' class='newsfeed_icon'></a></li>
                <li style="float:right"><a style='padding:0;margin:0;' href='message.php'><img src='images/msg.png' class='newsfeed_icon'></a></li>
                <li style="float:right"><a style='padding:0;margin:0;' href='navigation.php'><img src='images/navigation.png' class='newsfeed_icon'></a></li>

            </ul>
          </div>
        </div>
        
        
        <div id='postbox' class='postbox' style='background-color:#FAFAFA;margin-top: 40px;'>    
        </div>
    
    
        
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <div style='text-align:center;margin-bottom:15px;'><a href="profile.php?username=sakib" id='modalusername' style='color:white'>User name</a></div>
            <img class="modal-content" id="img01" alt="description">
            <div id="caption"></div>
        </div>
        
        
        <script>
        
            var start = 0;
            var end = 48;
            
            var modal = document.getElementById('myModal');

            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            var modalUsername = document.getElementById("modalusername");
            function modalClick(element){
                modal.style.display = "block";
                modalImg.src = element.src;
                captionText.innerHTML = element.alt;
                modalUsername.innerHTML = element.id;
                modalUsername.href = "profile.php?username=" + element.id;
            }

            var span = document.getElementsByClassName("close")[0];

            span.onclick = function() { 
                modal.style.display = "none";
            }
            
            function openModal(element){
                document.getElementById('modalimg').src = element.src;
                document.getElementById('modal01').style.display='block';
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
                        end = start+9;
                    }
                };
                xmlhttp.open("GET", "navigationResponse.php?q=load&start="+start.toString()+"&end="+end.toString(), true);
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
                xmlhttp.open("GET", "navigationResponse.php?q=load&start="+start.toString()+"&end="+end.toString(), true);
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

        </script>
    
    </body>

</html>