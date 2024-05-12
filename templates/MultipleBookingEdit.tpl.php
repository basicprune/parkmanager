
<?php $sites = ParkManagerService::getInstance($w)->getSiteTypes(ParkManagerService::getInstance($w)->GetAllSites());?>



<form method="POST" action="/parkmanager/MultipleBookingEdit">

<div class="row-fluid clearfix small-12 multicolform"><div class="panel clearfix" id="guestpanel"><div class="row-fluid clearfix section-header"><h4>Details For Guest Booking<span style="display: none;" class="changed_status right alert radius label">changed</span></h4></div>

<!-- <ul class="small-block-grid-1 medium-block-grid-2 section-body"><li><label class="small-12 columns">First Name<div><input style="width:100%;" type="text" name="firstname" value="" size="" id="firstname"><div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"><template shadowrootmode="closed"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" data-lastpass-icon="true" style="position: absolute; cursor: pointer; height: 22px; max-height: 22px; width: 22px; max-width: 22px; top: 7.8px; left: 336.8px; z-index: auto; color: rgb(215, 64, 58);"><rect x="0.680176" y="0.763062" width="22.6392" height="22.4737" rx="4" fill="currentColor"></rect><path fill-rule="evenodd" clip-rule="evenodd" d="M19.7935 7.9516C19.7935 7.64414 20.0427 7.3949 20.3502 7.3949C20.6576 7.3949 20.9069 7.64414 20.9069 7.9516V16.0487C20.9069 16.3562 20.6576 16.6054 20.3502 16.6054C20.0427 16.6054 19.7935 16.3562 19.7935 16.0487V7.9516Z" fill="white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.76288 13.6577C5.68525 13.6577 6.43298 12.9154 6.43298 11.9998C6.43298 11.0842 5.68525 10.3419 4.76288 10.3419C3.8405 10.3419 3.09277 11.0842 3.09277 11.9998C3.09277 12.9154 3.8405 13.6577 4.76288 13.6577Z" fill="white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.3298 13.6577C11.2521 13.6577 11.9999 12.9154 11.9999 11.9998C11.9999 11.0842 11.2521 10.3419 10.3298 10.3419C9.4074 10.3419 8.65967 11.0842 8.65967 11.9998C8.65967 12.9154 9.4074 13.6577 10.3298 13.6577Z" fill="white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M15.8964 13.6577C16.8188 13.6577 17.5665 12.9154 17.5665 11.9998C17.5665 11.0842 16.8188 10.3419 15.8964 10.3419C14.974 10.3419 14.2263 11.0842 14.2263 11.9998C14.2263 12.9154 14.974 13.6577 15.8964 13.6577Z" fill="white"></path></svg></template></div></div></label></li><li><label class="small-12 columns">Last Name<div><input style="width:100%;" type="text" name="lastname" value="" size="" id="lastname"></div></label></li></ul><ul class="small-block-grid-1 medium-block-grid-2 section-body"><li><label class="small-12 columns">Mobile<div><input style="width:100%;" type="text" name="mobile" value="" size="" id="mobile"></div></label></li><li><label class="small-12 columns">Email<div><input style="width:100%;" type="text" name="email" value="" size="" id="email"></div></label></li></ul> -->


</div>
<button type="button" onmousedown="addGuestFields()" style="background-color: #008CBA; border-color: #007095;">Click Me!</button>

<div class="panel clearfix"><div class="row-fluid clearfix section-header"><h4>Booking Details<span style="display: none;" class="changed_status right alert radius label">changed</span></h4></div>
<ul class="small-block-grid-1 medium-block-grid-2 section-body">
    <li>
        <label class="small-12 columns">Start Of Stay <small>Required</small><input name="dt_startofstaydate" required="" type="date" class="small-12 columns" id="dt_startofstaydate"></label>
    </li>
    <li>
        <label class="small-12 columns">End Of Stay <small>Required</small><input name="dt_endofstaydate" required="" type="date" class="small-12 columns" id="dt_endofstaydate"></label>
    </li>
</ul>
<ul class="small-block-grid-1 medium-block-grid-2 section-body">
    <li>
        <label class="small-12 columns">Rate <small>Required</small><input name="rate" required="" type="text" class="small-12 columns" id="rate" style="width: 100%;"></label>
    </li>
    <li>
        <label class="small-12 columns">Site<select name="sites" id="site-select" class="small-12 columns" >
  <option value="">--Please choose an option--</option></select></label>
    </li>
</ul>
</div>


    
    <button type="submit" class="button medium-5 small-12">Save</button>
</form>




<script>
var numOfGuests = 0;
window.onload = function() {
    addGuestFields();
    addSiteOptions();
};


function addGuestFields() {
    var guestPanel = document.getElementById("guestpanel");
    
    
    // Create the first set of input fields
    var ul1 = document.createElement("ul");
    ul1.className = "small-block-grid-1 medium-block-grid-2 section-body";

    var li1 = document.createElement("li");
    var label1 = document.createElement("label");
    label1.className = "small-12 columns";
    label1.textContent = "First Name";
    var input1 = document.createElement("input");
    input1.style.width = "100%";
    input1.type = "text";
    input1.name = "firstname" + numOfGuests;
    input1.id = "firstname" + numOfGuests;
    input1.placeholder = "Enter your first name";
    label1.appendChild(input1);
    li1.appendChild(label1);
    ul1.appendChild(li1);

    var li2 = document.createElement("li");
    var label2 = document.createElement("label");
    label2.className = "small-12 columns";
    label2.textContent = "Last Name";
    var input2 = document.createElement("input");
    input2.style.width = "100%";
    input2.type = "text";
    input2.name = "lastname" + numOfGuests;
    input2.id = "lastname" + numOfGuests;
    input2.placeholder = "Enter your last name";
    label2.appendChild(input2);
    li2.appendChild(label2);
    ul1.appendChild(li2);

    guestPanel.appendChild(ul1);
    
    // Create the second set of input fields
    var ul2 = document.createElement("ul");
    ul2.className = "small-block-grid-1 medium-block-grid-2 section-body";

    var li3 = document.createElement("li");
    var label3 = document.createElement("label");
    label3.className = "small-12 columns";
    label3.textContent = "Mobile";
    var input3 = document.createElement("input");
    input3.style.width = "100%";
    input3.type = "text";
    input3.name = "mobile" + numOfGuests;
    input3.id = "mobile" + numOfGuests;
    input3.placeholder = "Enter your mobile number";
    label3.appendChild(input3);
    li3.appendChild(label3);
    ul2.appendChild(li3);

    var li4 = document.createElement("li");
    var label4 = document.createElement("label");
    label4.className = "small-12 columns";
    label4.textContent = "Email";
    var input4 = document.createElement("input");
    input4.style.width = "100%";
    input4.type = "text";
    input4.name = "email" + numOfGuests ;
    input4.id = "email" + numOfGuests;
    input4.placeholder = "Enter your email";
    label4.appendChild(input4);
    li4.appendChild(label4);
    ul2.appendChild(li4);

    guestPanel.appendChild(ul2);
    numOfGuests++;
}

</script>

<style>

    .booked{
        color: #dda00e;
    }
    .avaliable{
        color: green;
    }
    .undermaintenence{
        color: red;
    }

</style>

<script>


    
function addSiteOptions() {
    var select = document.getElementById("site-select");    
    select.name = "site";
    var tests = <?php echo json_encode($sites); ?>;
    console.log(tests[0]);
    
    for(var i = 0; i < tests.length; i++)
    { 
        var option = document.createElement("option");

        //

        if (tests[i].substr(tests[i].indexOf("(", 0), 5) == "(Is B"){
            option.className = "booked";
        } else if(tests[i].substr(tests[i].indexOf("(", 0), 5) == "(Is A"){
            option.className = "avaliable";
        }else if(tests[i].substr(tests[i].indexOf("(", 0), 2) == "(U"){
            option.className = "undermaintenence";
        }


        console.log(tests[i].substr(tests[i].indexOf("(", 0), tests[i].length));

        option.textContent = tests[i];
        option.value = tests[i].substr(0, tests[i].indexOf(" ", 0));
        option.name = tests[i].substr(0, tests[i].indexOf(" ", 0));
        option.id = tests[i].substr(0, tests[i].indexOf(" ", 0));
        select.appendChild(option);

        // document.write(passedArray[i]);     
    } 
    // var option = document.createElement("option");




}
</script>