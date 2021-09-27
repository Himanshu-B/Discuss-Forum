<?php include 'header.php' ?>
<?php
    //check for loggedin user
    if(isset($_SESSION['loggedin'])){
        $auser = $_SESSION['active_user'];
        $auid = $_SESSION['active_userid'];
    }else{
        header('location: index.php');
    }
?>
<div style="margin-left:200px">
<?php
// display all threads posted by respective registered users on their 'mypost' page
// to avoid interchange of data for same name user we use their id to distinguish them
    $q = "SELECT * FROM threads WHERE thread_user='$auser' AND thread_user_id='$auid'";
    $r = mysqli_query($conn,$q);
    $t = mysqli_fetch_all($r,MYSQLI_ASSOC);
?>
</div>

    <div class="container">
        <span style="background:darkslategray; position:fixed; top:0; left:0;width:225px; height:100%; z-index:-1"></span>
        <div class="sidebar">
            <ul>
                <li><a href="welcome.php"><i class="fas fa-th-large"></i><span>Dashboard</span></a></li>
                <li><a href="mydiscuss.php"><i class="far fa-file-alt"></i><span>New Discuss</span></a></li>
                <li><a href="myprofile.php"><i class="fas fa-user"></i><span>My Profile</span></a></li>
                <li><a href="mypost.php"><i class="fas fa-folder"></i><span>My Posts</span></a></li>
                <li><a href="#"><i class="fas fa-comments"></i><span>My Comments</span></a></li>
            </ul>
        </div>
        <div class="sidecontent">
            <?php
                if(isset($_GET['msg']))
                echo 'Post has been Deleted Permanently';
            ?>
            <h2>My Posted Questions</h2>
            <?php if(mysqli_num_rows($r)): ?>
            <div class="results">
                <?php foreach($t as $th): ?>
                <div class="lists">
                    <a href="thread.php?tid=<?php echo $th['thread_id'];?>"></a>
                    <div class="ques">
                        <h3><?php echo $th['thread_title'];?></h3>
                        <p><?php echo substr_replace($th['thread_content'], "...", 250);?></p>
                        <hr>
                        <p><em><b><?php
                        $thid = $th['thread_id'];
                        $ct = "SELECT * FROM comments WHERE thread_id='$thid'";
                        $rt = mysqli_query($conn,$ct);
                        $nt = mysqli_num_rows($rt);
                        echo $nt;
                        ?> COMMENTS</b></em></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else:?>
                <div style="background:rgb(204, 204, 179); margin:5px 10px; height:150px; display:flex; justify-content:center; align-items:center">
                    <em><h2><p style="text-align:center">NO POST HERE!!!!</p></h2>
                    <small>use 'New Dicuss' to start creating posts and will display here</small></em>
                </div>
            <?php endif;?>
        </div>
        <p style="margin-left:200px">Ajax Load Data from Database Using LOAD MORE button</p>
        <div id="ajaxload" style="margin-left:200px">
        </div>
        <span style="margin-left:300px"><button onclick="loadMore()">LOAD MORE</button></span>
    </div>
    <br><br>
    <script>
        // Starting position to get new records
        var record = 0;
        var set = 3;
        // This function will be called every time a button pressed 
        function loadMore(){
            var ajax = new XMLHttpRequest();
            ajax.open("GET","ajaxloadmore.php?record="+record+"&set="+set, true);
            ajax.onload = function(){
                if(this.readyState == 4 && this.status == 200){
                    // Converting JSON string to Javasript array
                    var data = JSON.parse(this.responseText);
                    var html = "";
                    // Appending all returned data in a variable called html
                    for(var a=0; a<data.length; a++){
                        html += `<div class="lists">
                        <a href="thread.php?tid=${data[a].thread_id}"></a>
                        <div class="ques">
                            <h3>${data[a].thread_title}</h3>
                        </div>
                    </div>`;
                    }
                    // Appending the data below old data in <div> tag
                    document.getElementById('ajaxload').innerHTML += html;
                    // Incrementing the offset so you can get next records when that button is clicked
                    record = record + set;
                }
            }
            ajax.send();
        }
        // Calling the function on page load
        window.onload = loadMore();
    </script>
<?php include 'footer.php' ?>