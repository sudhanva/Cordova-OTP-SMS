<HTML>
  <BODY>
  <div>
        <div ID="Label1" style="font-size:24pt;font-weight:bold;"></div>
        <input type="button" onclick="ActivateTimer();" value="Activate" />
        <script language="javascript" type="text/javascript">
            var min = 1;
            var sec = 59;
            var timer;
            var timeon = 0;
            function ActivateTimer() {
                if (!timeon) {
                    timeon = 1;
                    Timer();
                }
            }
            function Timer() {
                var _time = min + ":" + sec;
                document.getElementById("Label1").innerHTML =_time;
                if (_time != "0:0") {
                    if (sec == 0) {
                        min = min - 1;
                        sec = 59;
                    } else {
                        sec = sec - 1;
                    }
                    timer = setTimeout("Timer()", 1000);
                }
                else {
                    alert("Time is Over");
                }
            }
        </script>

    </div>
 </BODY>
</HTML>