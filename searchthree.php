<?php include 'header.php' ?>

<?php
    $alert_msg="";
    // submit to search again when coming from index.php for query search
    if(isset($_GET['submit'])){
        // trim is used to handle blank space as search query or remove any blank space 
        $text = trim($_GET['search_query']);
        $text = htmlspecialchars($text);

        if(!empty($text)){
            // first method to display data when search query is executed
            $s_query = "SELECT * FROM threads WHERE match (thread_title,thread_content) against ('$text')";
            $s_result = mysqli_query($conn,$s_query);

            // to handle bool(false) which is returned by query
            if(is_bool($s_result)){
                $alert_msg = 'Enter proper search term';
                $s_num="";
            }else{
                $s_num = mysqli_num_rows($s_result);
                $s_row = mysqli_fetch_all($s_result,MYSQLI_ASSOC);
                // second method to display data after search query failed by first method
                if($s_num){
                    $alert_msg = 'result shown below';
                }else{
                    $search_text = htmlspecialchars($text);
                    $s_query2 = "SELECT * FROM threads WHERE thread_title LIKE '%$search_text%' OR thread_content LIKE '%$search_text%'";
                    $s_result2 = mysqli_query($conn,$s_query2);
                    $s_num = mysqli_num_rows($s_result2);
                    $s_row = mysqli_fetch_all($s_result2,MYSQLI_ASSOC);
                }
            }
        }else{
            $alert_msg = 'Empty field can not be searched';
            $s_num = "";
        }
    }
?>

    <div class="container">
        <div class="msg">
            <p><?php echo $alert_msg; ?></p>
        </div>
        <div class="search-bar">
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
                <div class="form-control">
                    <input type="text" name="search_query" placeholder="Search thread here...">
                </div>
                <input type="submit" value="Search Thread" name="submit">
            </form>
        </div>
        <br>
        <hr>

        <div class="results">
            <h2>Search results for "<?php echo htmlspecialchars($_GET['search_query']);?>"</h2>
        <?php if($s_num): ?>
            <?php foreach($s_row as $row): ?>
                <div class="lists">
                    <a href="thread.php?tid=<?php echo $row['thread_id'];?>"></a>
                    <div class="ques">
                        <h3><?php echo $row['thread_title'];?></h3>
                        <p><?php echo $row['thread_content'];?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="margin:10px 20px">No Results Found</p>
            <ul style="margin:5px 40px">
                <li>Make sure that all words are typed correctly</li>
                <li>Try different keywords</li>
                <li>Try general keywords</li>
                <li>Avoid searching with only special character</li>
            </ul>
        <?php endif; ?>
        </div>
    </div>

<?php include 'footer.php' ?>



<!-- search:
python java
c++
<tjhbjbs>
java
('.message')
{ -->