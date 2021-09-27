<?php include 'header.php' ?>

<?php 
     $sql = "SELECT * FROM `category` ";
     $result = mysqli_query($conn, $sql);
     $num = mysqli_num_rows($result);
    //  echo $num;
    $cat = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // var_dump($cat);
?>
    <div class="container">
        <section class="catg">
            <h1>Browse Categories:</h1>
            <div class="card-area">
                <!-- Iterate All Category here -->
                <?php foreach($cat as $catg): ?>
                <div class="card">
                    <a href="threadlist.php?catid=<?php echo $catg['category_id'];?>"><?php echo $catg['category_name'];?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
<?php include 'footer.php' ?>