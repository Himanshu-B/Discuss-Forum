<?php include 'header.php' ?>
<?php
    // [with default collation 'utf8mb4_general_ci' of a table]
    //FULLTEXT as index is added before search function implementation in database table using below query
    // ALTER TABLE threads ADD FULLTEXT(`thread_title`,`thread_content`);

    // to search again
    if(isset($_GET['submit'])){
        $text = mysqli_real_escape_string($conn,$_GET['search_query']);
        // trim is used to handle blank space as search query
        if(!empty(trim($text))){
            $s_query = "SELECT * FROM threads WHERE match (thread_title,thread_content) against ('$text')";
            $s_result = mysqli_query($conn,$s_query);
            $s_num = mysqli_num_rows($s_result);
            $s_row = mysqli_fetch_all($s_result,MYSQLI_ASSOC);
        }else{
            echo 'Empty field can not be searched';
            // for undefined result $s_num is defined here to avoid error
            $s_num = "";
        }
    }

?>

    <div class="container">
        <div class="search-bar">
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
                <div class="form-control">
                    <input type="text" name="search_query" placeholder="Search thread here...">
                </div>
                <input type="submit" value="Search" name="submit">
            </form>
        </div>
        <br>
        <hr>

        <div class="results">
            <h2>Search results for "<?php echo mysqli_real_escape_string($conn,$_GET['search_query']);?>"</h2>
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
                <li>Don't search using single keyword like: how,the,as,if,is... etc</li>
                <li>Try general keywords</li>
                <li>Avoid searching with only special character</li>
            </ul>
        <?php endif; ?>
        </div>
    </div>

<?php include 'footer.php' ?>



search:
python java
c++
<>
java
<a