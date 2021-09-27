<?php include 'header.php'?>

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
        <br>
    </div>

    <script>
        const cform = document.getElementById("c_form");

        c_form.addEventListener("submit",function(e){
            // here trim function is used to avoid 'space' only as input value in database
            const cname = document.getElementById("n").value.trim();
            const cemail = document.getElementById("e").value.trim();
            const csubject = document.getElementById("s").value.trim();
            const cmsg = document.getElementById("m").value.trim();

            e.preventDefault();

            const xhr = new XMLHttpRequest();
            // below function will send data to respective url
            xhr.open("post","s.php",true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.onload = function(){
                if(this.status === 200){
                    // document.querySelector(".contact-form").innerHTML = 'You will be contacted soon';
                    // here we will get response from s.php and will show here
                    document.querySelector(".contact-form").innerHTML = this.response;
                    // setTimeout(function () { window.location.href = "contact.php"; }, 2000);
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



