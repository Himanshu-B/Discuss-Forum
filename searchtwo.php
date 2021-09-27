<?php include 'header.php' ?>
<?php
    // to search again
    if(isset($_GET['submit'])){
        $text = $_GET['search_query'];
        // trim is used to handle blank space as search query
        if(!empty(trim($text))){
            $search_text = mysqli_real_escape_string($conn,$text);
            $s_query = "SELECT * FROM threads WHERE thread_title LIKE '%$search_text%' OR thread_content LIKE '%$search_text%'";
            $s_result = mysqli_query($conn,$s_query);
            $s_num = mysqli_num_rows($s_result);
        }else{
            echo 'Empty field can not be searched';
            // for undefined result $s_num is defined here to avoid error
            $s_num="";
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
            <?php while($s_row = mysqli_fetch_assoc($s_result)): ?>
            <div class="lists">
                <a href="thread.php?tid=<?php echo $s_row['thread_id'];?>"></a>
                <div class="ques">
                    <h3><?php echo $s_row['thread_title'];?></h3>
                    <p><?php echo $s_row['thread_content'];?></p>
                </div>
            </div>
            <?php endwhile; ?>

        <?php else: ?>
            <p style="margin:10px 20px">No Results Found</p>
            <ul style="margin:5px 40px">
                <li>Make sure that all words are typed correctly</li>
                <li>Don't search for more than one category keywords like python java, php sql, java python</li>
                <li>Search with single keywords</li>
                <li>Try general keywords</li>
            </ul>
        <?php endif; ?>
        </div>
    </div>
<?php include 'footer.php' ?>


search:
python java
c++
how to python