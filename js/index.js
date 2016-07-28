$(document).ready(function(){
  var myDB;
//Open Database Connection
document.addEventListener("deviceready",onDeviceReady,false);
function onDeviceReady(){
  /*Start------This is get the Phone Registration ID*/
  console.log("Device Ready")
  var push = PushNotification.init({ "android": {"senderID": "972888279375"},
    "ios": {"alert": "true", "badge": "true", "sound": "true"}, "windows": {} } );

  push.on('registration', function(data) {
    console.log(data.registrationId);
    $("#gcm_id").html(data.registrationId);
  });

  push.on('notification', function(data) {
    console.log(data.message);
    alert(data.title+" Message: " +data.message+data.image);
// data.title,
// data.count,
// data.sound,
// data.image,
// data.additionalData
});

  push.on('error', function(e) {
    console.log(e.message);
  });
  /*End------This is get the Phone Registration ID*/
/* document.getElementById("cordovaDevice").addEventListener("click", cordovaDevice);
*/
document.getElementById("demo").innerHTML = device.uuid;
myDB = window.sqlitePlugin.openDatabase({name: "mySQLite.db", location: 'default'});
myDB.transaction(function(transaction) {
  transaction.executeSql
  ('CREATE TABLE IF NOT EXISTS registration (id integer primary key, Name text, ISDCode text, MobileNo VARCHAR(15),EmailID VARCHAR(100), uuid VARCHAR(20), gcmID VARCHAR(200),sender_id VARCHAR(20))', [],
    function(tx, result) {
      alert("Table created successfully");
    }, 
    function(error) {
      alert("Error occurred while creating the table.");
    });
});
}
//Create new table
$("#createTable").click(function(){

});
/*function cordovaDevice() {
 alert("Cordova version: " + device.cordova + "\n" +
  "Device model: " + device.model + "\n" +
  "Device platform: " + device.platform + "\n" +
  "Device UUID: " + device.uuid + "\n" +
  "Device version: " + device.version);

}*/

//Insert New Data
$("#verify").click(function(){
  var Name =$("#fname").val();
  var ISDCode=$("#isd").val();
  var MobileNo=$("#mobile").val();
  var EmailID=$("#email").val();
  var uuid=document.getElementById("demo").innerHTML;
  var gcmID=document.getElementById("gcm_id").innerHTML;
  var sender_id = "972888279375";
var timestamp = Date.now();
  alert(timestamp);
  console.log(Name +""+ ISDCode +""+ MobileNo +""+ EmailID + "" + uuid + "" + gcmID +"" + sender_id );
  if(Name == '' || ISDCode == '' || MobileNo == '' || EmailID == '')
  {
    alert("u must fill all field");
    return false;
  }
  else{
    myDB.transaction(function(transaction) {
      var executeQuery = "INSERT INTO registration (Name, ISDCode , MobileNo, EmailID, uuid, gcmID, sender_id) VALUES (?,?,?,?,?,?,?)";             
      transaction.executeSql(executeQuery, [Name, ISDCode , MobileNo, EmailID, uuid, gcmID, sender_id]
        , function(tx, result) {
      // alert('Inserted');

    },
    function(error){
     alert('Error occurred on Sqllite Insert'); 
   });
    });
  }

});

//Display Table Data
$("#showTable").click(function(){
  $("#TableData").html("");
  myDB.transaction(function(transaction) {
    transaction.executeSql('SELECT * FROM registration', [], function (tx, results) {                  
     var len = results.rows.length, i;
     $("#rowCount").html(len);
     for (i = 0; i < len; i++){                                                                                                                                                                                                                                                                                                    
      $("#TableData").append("<tr><td>"+results.rows.item(i).id+"</td>&nbsp;<td>"+results.rows.item(i).Name+"</td>&nbsp;<td>"+results.rows.item(i).ISDCode+"</td>&nbsp;<td>"+results.rows.item(i).MobileNo+"</td>&nbsp;<td>"+results.rows.item(i).EmailID+"</td>&nbsp;<td>"+results.rows.item(i).uuid+"</td>&nbsp;<td>"+results.rows.item(i).gcmID+"</td>&nbsp;<td>"+results.rows.item(i).sender_id+"</td></tr>");
    }
  }, null);
  });
});

//Drop Table
$("#DropTable").click(function(){
  myDB.transaction(function(transaction) {
    var executeQuery = "DROP TABLE IF EXISTS registration";
    transaction.executeSql(executeQuery, [],
      function(tx, result) {alert('Table deleted successfully.');
      location.reload();},
      function(error){alert('Error occurred while droping the table.');
    }
    );
  });
});
});
