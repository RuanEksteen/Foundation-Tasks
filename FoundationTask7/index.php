<?php
include 'person.class.php';
$personClassObj = new person();
$connObj = $personClassObj->OpenCon();
//$personClassObj->loadAllPeople($connObj);
?>
<!DOCTYPE html>
<html>
<title>Foundation task 7</title>
<head>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
        }
        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 4px;
        }
        #customers tr:nth-child(even){background-color: #f2f2f2;}
        #customers tr:hover {background-color: #ddd;}
        #customers th {
            padding-top: 6px;
            padding-bottom: 6px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
        button, select {
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        div {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>
</head>
<body>
<div style="width: 100%; overflow: hidden;">
    <div style="width: 57%; float: left;">
        <?php $personClassObj->loadAllPeople($connObj);?>
    </div>
    <div style="margin-left: 800px;">
        <button type='button' class='addBtn'>Add A user</button>
        <button type='button' class='addRandomBtn'>Add 10 users</button>
        <button type='button' class='deleteAllBtn'>Delete all Entries</button>
        <div id="tableDiv">
        </div>
    </div>
</div>


</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(".dltBtn").on("click",function (event) {
      let btnElement = $(this);
      let id = btnElement.closest("tr").attr("id");
      let btnId = "DeleteBtn";
      console.log("clicked update",btnElement.closest("tr").attr("id"));
      $.post( "update.php", {id : id, btnId : btnId}, function( data ) {
          $( "#tableDiv" ).html( data );
      });
      location.reload();
  });
  $(".updBtn").on("click", function (event) {
      $("html").animate({ scrollTop: 0 }, "slow");
      let btnElement = $(this);
      let id = btnElement.closest("tr").attr("id");
      let btnId = "EditBtn";
      console.log("clicked update",btnElement.closest("tr").attr("id"));
      $.post( "update.php", {id : id, btnId : btnId}, function( data ) {
          $( "#tableDiv" ).html( data );
          $('#customers').DataTable().ajax.reload();
      });
  });
  $(document).on("click",".submitBtn",function (event) {
      event.preventDefault();
      let btnId = "SubmitBtn";
      let id = $("#id").val();
      let name = $("#firstname").val();
      let surname = $("#lastname").val();
      let DateOfBirth = $("#DateOfBirth").val();
      let email = $("#Email").val();
      console.log("clicked submit");
      $.post( "update.php", {id : id, btnId : btnId, name : name, surname : surname, DateOfBirth : DateOfBirth, email : email }, function( data ) {
          $( "#tableDiv" ).html( data );
      });
  });
  $(".addRandomBtn").on("click", function (event) {
      let btnId = "AddRandomBtn";
      console.log("clicked add 10");
      $.post( "update.php", {btnId : btnId}, function( data ) {
          $( "#tableDiv" ).html( data );
      });
  });
  $(".deleteAllBtn").on("click", function (event) {
      let btnId = "DeleteAllBtn";
      console.log("clicked delete all");
      $.post( "update.php", {btnId : btnId}, function( data ) {
          $( "#tableDiv" ).html( data );
      });
  });
  $(".addBtn").on("click", function (event) {
      let btnId = "AddBtn";
      console.log("clicked delete all");
      $.post( "update.php", {btnId : btnId}, function( data ) {
          $( "#tableDiv" ).html( data );
      });
  });
</script>
<?php $personClassObj->CloseCon($connObj); ?>
</html>