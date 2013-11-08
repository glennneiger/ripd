<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/ConnectDB.inc';
include 'includes/header.php';
?>
<?php
$flag = 'false';

function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}
?>
<title>চার্জ মেইকিং</title>
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script>
    var fieldName='chkName[]';
    function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }


    function checkIt(evt) {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
            status = ""
            return true
        }
        status = "This field accepts numbers only."
        return false
    }
</script>

<?php
//$rowEntry = mysql_query("SELECT * FROM charge");
//$rowNumber = mysql_num_rows($rowEntry);
//$selectCharge = mysql_query("Select * from charge");
//$rows_selected_charge = mysql_num_rows($selectCharge);
if (isset($_POST['submit']) && ($_GET['action'] == 'new')) {

    $new_charge_criteria_name = $_POST['charge_criteria_name'];
    $new_charge_amount = $_POST['charge_amount'];
    $new_charge_status = "Active";
    $newChargeInsert = "INSERT INTO charge (charge_criteria ,charge_amount ,charge_status) values('$new_charge_criteria_name', '$new_charge_amount', '$new_charge_status')";

    if (mysql_query($newChargeInsert)) {
        //$msg = "আপনি সফলভাবে " . $new_charge_criteria_name . " নামে নতুন চার্জটি তৈরি করেছেন";
        //$flag = 'true';
    } else {
        //$msg = "দুঃখিত, আবার চেষ্টা করুন";
        //$flag = 'false';
    }
            header("Location:charge_making_1.php");
}
?>      

<?php
if ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 63%; float: left"><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"><b>ফিরে যান</b></a></div>
        <div  ><a href="charge_making.php?action=new"> নতুন চার্জ</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">চার্জ পরিবর্তন</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="" name="" action="">

            <table  class="formstyle" style="font-family: SolaimanLipi !important; width: 78%;">          
                <tr><th colspan="2" style="text-align: center;">নতুন চার্জ  মেইকিং</th></tr>
                <tr>
                    <td>চার্জ নাম</td>
                    <td>: <input class="box" type="text" id="charge_criteria_name" name="charge_criteria_name" value=""/></td>
                </tr>
                <tr>
                    <td>চার্জ পরিমান</td>
                    <td>: <input class="box" type="text" id="charge_amount" name="charge_amount" value="" onkeypress="return checkIt(event)"/> টাকা</td>
                </tr>    
                <tr>                    
                    <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                </tr>  

            </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 63%; float: left"><a href="index.php?apps=HRE"><b>ফিরে যান</b></a></div>
        <div><a href="charge_making.php?action=new"> নতুন চার্জ </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">চার্জ পরিবর্তন</a></div>
    </div>
    <div>
        <table  class='formstyle' style='font-family: SolaimanLipi !important; width: 78%;'>          
            <tr><th colspan='2' style='text-align: center;'>চার্জ পরিবরতন</th></tr>
            <?php
            $selectCharge = mysql_query("Select * from charge");
            $num_of_charge_criteria = mysql_num_rows($selectCharge);
            if($num_of_charge_criteria < 1){
                echo "<tr><td colspan='2' style='text-align:center;'>কোনো চার্জের ধরণ তৈরি করা হয় নাই,<a href='charge_making.php?action=new'> নতুন চার্জ তৈরি করুন </a></td></tr>";
            }
            while ($selectChargeRow = mysql_fetch_array($selectCharge)) {
                $db_charge_id_selected = $selectChargeRow['idcharge'];
                $db_charge_criteria_selected = $selectChargeRow['charge_criteria'];
                $db_charge_amount_selected = $selectChargeRow['charge_amount'];
                $db_charge_status_selected = $selectChargeRow['charge_status'];
                echo "<form method='POST' onsubmit='' name='' action='edit_charge.php'>";
                echo " <tr>
                        <td>$db_charge_criteria_selected<input type='hidden' id='charge_criteria_id' name='charge_criteria_id' value='$db_charge_id_selected'/></td>                        
                            <input type='hidden' id='charge_status' name='charge_status' value='$db_charge_status_selected'/>";

                if ($db_charge_status_selected == 'Active') {
                    echo"<td>: <input class='box' type='text' id='charge_criteria_amount' name='charge_criteria_amount' value='$db_charge_amount_selected' /> Taka
                                  <input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: #0099A1 !important;height: 20px !important;width: 100px;'/>
                                  <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: red !important;height: 20px !important;width: 100px;'/>
                                  <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>";
                } else {
                    echo"<td>: <input class='box' type='text' id='charge_criteria_amount' name='charge_criteria_amount' value='$db_charge_amount_selected' disabled='true' /> Taka
                                    <input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
                                    <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
                                    <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: green !important;height: 20px !important;width: 100px;'/>";
                }
                echo "</td> 
                                  </tr></form>";
            }
            ?>   
        </table>
    </div>
    <?php
}
include_once 'includes/footer.php';
?>