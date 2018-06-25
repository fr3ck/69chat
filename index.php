<html>
    <head>
        <title>Chat Room</title>
        <link rel = "stylesheet" href = "./css/bootstrap.css">
        <link rel = "stylesheet" href = "./css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <script src="https://www.gstatic.com/firebasejs/3.6.4/firebase.js"></script>
        <script src="./js/jquery.js"></script>
        <script>
            // Initialize Firebase
            var config = {
                apiKey: "AIzaSyCgOVJQo3VB5RpY933DD1n6VQ9sgzu33iQ",
                authDomain: "chat-7745a.firebaseapp.com",
                databaseURL: "https://chat-7745a.firebaseio.com",
                projectId: "chat-7745a",
                storageBucket: "chat-7745a.appspot.com",
                messagingSenderId: "516457509614"
            };
            firebase.initializeApp(config);

            function ReadMessages(room) {
                    firebase.database().ref(room).limitToLast(10).on('child_added', function(snapshot){
                    // firebase.database().ref(room).once('child_added').then(function(snapshot){
                        var data = "<div id = 'm'><p class = 'name'>"
                                    + snapshot.child('name').val() 
                                    + "</p><p class = 'message'>" 
                                    + snapshot.child('message').val()
                                    + "</p></div>";
                    $("#messages").html($("#messages").html() + data);
                });
            }

            function magic_number(value) {
                var num = $("#number");
                num.animate({count: value}, {
                    duration: 500,
                    step: function() {
                        num.text(string(parseint(this.count)));
                    }
                });
            };

            function update() {
                $.getJSON("count.php?jsonp=?", function(data) {
                    console.log(data.n);
                    // magic_number(data.n);
                });
            };

            $(document).ready(function(){

                $("#name_submit").click(function(){
                    room = 'chat/';
                    gender = $('input[name=gender]:checked').val();
                    name = $("#name").val();
                    $("#name_prompt_parent").fadeOut();

                    ReadMessages(room);

                    firebase.database().ref(room + Date.now()).set({
                        name: "",
                        message: "<i>" + name + " joined the chatroom</i>"
                    });

                    $("#messages").scrollTop(1200);
                }); 
                
                $("#send_button").on('click', function(){
                    var mess = $("#msg").val();
                    firebase.database().ref(room+ Date.now()).set({
                        gender:gender,
                        name: name,
                        message: mess
                    });
                    update();
                    $("#msg").val("");
                });
                $("#send_button").click(function(){
                    $("#messages").scrollTop(1200);
                });
                
                $("#newchat").on('click',function(){
                    // firebase.database().onRestart();
                    token=Math.random().toString(36).substring(7);
                    roomnum=token+'/';
                    room=roomnum;

                    firebase.database().ref(roomnum).limitToLast(10).on('child_added', function(snapshot){
                    var data = "<div id = 'm'><p class = 'name'>" 
                    + snapshot.child('name').val() 
                    // + "</p><p class = 'gender'>"
                    // + snapshot.child('gender').val()
                    + "</p><p class = 'message'>" 
                    + snapshot.child('message').val()
                    + "</p></div>";

                    $("#messages").html($("#messages").html() + data);
                    });

                    firebase.database().ref(roomnum + Date.now()).set({
                        name: 'Room ID:',
                        message: token
                    });

                    firebase.database().ref(roomnum+ Date.now()).set({
                        name: "",
                        message: "<i>" + name + " joined the chatroom</i>"

                    });

                
                    
                });

                $("#send_room_num").on('click',function(){
                    $("#name_submit").off("click");
                    var roomnum=$("#room_num").val()+'/';
                    room=roomnum;
                    $( "#messages" ).empty();
                    ReadMessages(room);
                    firebase.database().ref(room+ Date.now()).set({
                        name: "",
                        message: "<i>" + name + " joined the chatroom</i>"

                    });
                });

                document.onkeydown = function(e) {
                    var ev = document.all ? window.event : e;
                    if(ev.keyCode == 13){
                        $("#send_button").click();
                    }
                }
            });
            
        </script>

    </head>
    
    <body>
        <div id = "name_prompt_parent">
            <div id = "name_prompt">
                <input type = "text" id = "name" class = "form-control" required style="margin-top:40px; !important" placeholder="請輸入暱稱">
                <br>
                <input type = "radio" name = "gender"  value="boy" id="r1">
                <label for="r1"><span></span>男</label>
                <input type = "radio" name = "gender" value = "girl" id="r2">
                <label for="r2"><span></span>女</label>
                <br/>
                <button id = "name_submit" class = "btn btn-success">Submit</button>
            </div>
        </div>
        
        <div id="select">
            <div class="random">
                <button id="newchat" class="button">new chat room</button>
            </div>
            <div class="enternum">
                <input type="text" id="room_num" placeholder="請輸入房間號碼">
                <button id="send_room_num" class="button1">進入</button>
            </div>
        </div>
        <div class="count">當前在線：<span id="number"></span></div>
        <div id = "chatroom">
            <div id = "messages">
                
            </div>
            <div id = "input">
                <textarea id = "msg" class = "form-control" id = "message"></textarea>
                <button id = "send_button" class = "btn btn-primary">Send</button>
            </div>
        </div>
    
    </body>
</html>