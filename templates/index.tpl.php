<?php echo Html::b("/parkmanager/MultipleBookingEdit", "Add New Booking"); ?>
<?php 
$array = [1,2,3,4,5,6,7,8,9,10];

$testing = null;

// $form = [];
// $form = [
//     "Booking Details" => [
//         [
//             ["First Name", "select", "test", $array, $array]
//         ]
//     ]
// ];



//     echo Html::multiColForm($form, "/parkmanager/MultipleBookingEdit?Test=" . 1, "GET");
// echo Html::box("/parkmanager/MultipleBookingEdit?Test=" . $_POST['test'], "Add New ", true); ?>
<?php echo Html::box("/parkmanager/SiteEdit", "Add New Site", true); ?>
<?php echo Html::box("/parkmanager/SiteList", "View Sites", true); ?>
</br>
<?php echo $table; ?>



<?php 
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
$w->enqueueStyle(array("name" => "main.css", "uri" => "/modules/parkmanager/includes/fullcalendar-5.10.0/lib/main.css", "weight" => 1010));
$w->enqueueScript(array("name" => "main.js", "uri" => "/modules/parkmanager/includes/fullcalendar-5.10.0/lib/main.js", "weight" => 1010));


?>
<style>
  .Available {
    background-color: green;
  }
  .Unavailable {
    background-color: red;
  }
  .Late {
    background-color: orange;
  }
  .Canceled {
    background-color: grey;
  }
</style>


 <script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    titleFormat: { year: 'numeric', month: 'long', day: 'numeric' },
    headerToolbar: {
        start: "prev,next",
        center: 'title',
        end: 'dayGridMonth,list'
    },
    events: '/parkmanager-Html/myfeed',
    //events: JSON.parse('<?php //echo $events; ?>'),
    contentHeight: 650,
  });
  calendar.render();
});

</script>

<?php

  // if ($user->hasRole('school_manager')) {
  //   echo Html::b("/school_teacher/teachercalendar/?")
  // }
  
    

  // echo Html::box("/parkmanager/BookingEdit" . $Booking->id, "Add New Availability");
  
?>
<!-- <?php 
    // echo Html::filter("Filters", $filter_data, "/parkmanager-Html/calendar", "GET"); 
    // if (!empty($teacher_id)) {
    //     echo Html::b('/school-teacher/editavailability/teacher/' . $teacher_id, 'Add New Availability for ' . SchoolService::getInstance($w)->GetTeacherForId($teacher_id)->getFullName());
    // }
?> -->

<div id='calendar'></div>
<?php echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";?>
