<?php include 'header.php'?>
<!-- having both php and ajax on same page result into mess/irrelavent output  so dont try this way of coding-->
<?php
    if(isset($_POST['sb'])){
    //     $name = $_POST['n'];
    //     $email =$_POST['e'];
    //     $subject = $_POST['s'];
    //     $mesg = $_POST['m'];

    //     $name = $_POST['fname'];
    //     $email =$_POST['email'];
    //     $subject = $_POST['csub'];
    //     $mesg = $_POST['cmsg'];

        foreach($_POST as $data_value){
            echo $data_value;
            
        }
        exit();
    }

?>

    <div class="container">
        <div class="contact-form">
            <h1>Contact Us</h1>
            <!-- dont use method and action attributes in form to send data instead let them use in ajax only to send data-->
            <form id="c_form">
                <div class="form-control">
                    <label>Name</label>
                    <input type="text" name="n" id="n">
                </div>
                <div class="form-control">
                    <label>Email</label>
                    <input type="text" name="e" id="e" required>
                </div>
                <div class="form-control">
                    <label>Subject</label>
                    <input type="text" name="s" id="s" required>
                </div>
                <div class="form-control">
                    <label>Message/Query</label>
                    <textarea name="m" id="m" required></textarea>
                </div>
                <input type="submit" value="Submit" name="sb">
            </form>
        </div>
        <div class="somemsg"></div>
    </div>

    <script>
        const cform = document.getElementById("c_form");

        c_form.addEventListener("submit",function(e){
            const cname = document.getElementById("n").value;
            const cemail = document.getElementById("e").value;
            const csubject = document.getElementById("s").value;
            const cmsg = document.getElementById("m").value;

            e.preventDefault();

            const xhr = new XMLHttpRequest();
            // below function will send data to respective url
            // here blank url means it will send data to same page(i.e., shelf)
            xhr.open("post","",true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.onload = function(){
                if(this.status === 200){
                    // document.querySelector(".contact-form").innerHTML = 'You will be contacted soon';
                    // here we will get response from wrongcontact.php and will show here
                    document.querySelector(".contact-form").innerText = this.response;
                }else{
                    const displaymsg = document.querySelector(".somemsg");
                    displaymsg.innerHTML = 'Problem Occured while connecting';
                }
            }
            let cdata = "fname="+cname+"&email="+cemail+"&csub="+csubject+"&cmsg="+cmsg ;
            console.log(cdata);
            xhr.send(cdata);
        });
    </script>
<?php include 'footer.php'?>



