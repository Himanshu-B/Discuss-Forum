<?php include 'header.php' ?>
<?php
// display all threads on main page
    // $q = "SELECT * FROM threads ORDER BY thread_timestamp DESC";
    // $r = mysqli_query($conn,$q);
    // $t = mysqli_fetch_all($r,MYSQLI_ASSOC);
?>
<?php
    $per_page_record = 6;  // Number of entries to show in a page.   
    // Look for a GET variable page if not found default is 1.        
    if (isset($_GET["page"])) {    
        $page  = $_GET["page"];    
    } else {    
      $page=1;    
    }
    $start_from = ($page-1) * $per_page_record;     
    //  to display all threads
    $q = "SELECT * FROM threads ORDER BY thread_timestamp DESC LIMIT $start_from, $per_page_record";
    $r = mysqli_query($conn,$q);
    $t = mysqli_fetch_all($r,MYSQLI_ASSOC);
?>

    <div class="container">
        <div class="main-page">
            <p>This is a peer to peer forum. No Spam/Advertising/Self-promote in the forums is not allowed. Do not post copyright-infringing material. Do not post "Offensive" posts, links and images. Do not cross post questions. Remain respectful of other members at all times.</p>
        </div>
        <!-- search form -->
        <div class="search-bar">
            <!-- <form action="search.php" method="get"> -->
            <!-- <form action="searchtwo.php" method="get"> -->
            <form action="searchthree.php" method="get">
                <div class="form-control">
                    <input type="text" name="search_query" placeholder="Search thread here...">
                </div>
                <input type="submit" value="Search" name="submit">
            </form>
        </div>
        <br>
        <hr>
        <div class="results">
            <?php foreach($t as $th): ?>
            <div class="lists">
                <a href="thread.php?tid=<?php echo $th['thread_id'];?>"></a>
                <div class="ques">
                    <h3><?php echo $th['thread_title'];?></h3>
                    <p><?php echo $th['thread_content'];?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center">
        <div class="pagination">    
          <?php  
            $query = "SELECT COUNT(*) FROM threads";     
            $rs_result = mysqli_query($conn, $query);     
            $row = mysqli_fetch_row($rs_result);     
            $total_records = $row[0];     

            echo "</br>";
            // Number of pages required.   
            $total_pages = ceil($total_records / $per_page_record);
            $pagLink = "";
            if($page>=2){
                echo "<a href='index.php?page=".($page-1)."'>  Prev </a>";
            }

            for ($i=1; $i<=$total_pages; $i++) {   
              if ($i == $page) {   
                  $pagLink .= "<a class = 'active' href='index.php?page=".$i."'>".$i." </a>";
              }else{   
                  $pagLink .= "<a href='index.php?page=".$i."'>".$i." </a>";
              }
            };
            echo $pagLink;
            if($page<$total_pages){
                echo "<a href='index.php?page=".($page+1)."'>  Next </a>";
            }
          ?>
        </div>
        </div>
    </div>
    <br>
<?php include 'footer.php' ?>