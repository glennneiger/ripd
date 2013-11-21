<?php
error_reporting(0); 
include_once 'includes/ConnectDB.inc';
include_once 'includes/header.php'; 
$input= $_GET['id'];
$arrayAccountType = array('employee' => 'কর্মচারীর', 'customer' => 'কাস্টমারের', 'proprietor' => 'প্রোপ্রাইটারের');
$showAccountType  = $arrayAccountType[$input];
?>
<title>আপডেট অ্যাকাউন্ট</title>
<style type="text/css">@import "css/style.css";</style>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script type="text/javascript">
    function infoFromThana()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/updateEmpFromOffThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>
<div class="column6">
    <div class="main_text_box">      
        <div style="padding-left: 110px;">
            <?php if($input == 'proprietor') {$link = 'index.php?apps=OSP';}
                        elseif($input == 'customer') {$link = 'index.php?apps=CRM';}
                        else {$link = 'index.php?apps=HRE';}
            ?><a href="<?php echo $link;?>"><b>ফিরে যান</b></a></br>
        <div style="border: 1px solid grey;">
            <table  style=" width: 100%; margin-bottom: 10px;" > 
                    <tr><th style="text-align: center; background-image: radial-gradient(circle farthest-corner at center top , #FFFFFF 0%, #0883FF 100%);height: 45px;padding-bottom: 5px;padding-top: 5px;" colspan="2" ><h1>আপডেট <?php echo $showAccountType;?> অ্যাকাউন্ট</h1></th></tr>
            </table>
            <fieldset id="fieldset_style" style=" width: 90% !important; margin-left: 30px !important;" >
                <?php
                if($input=='employee') {
                    include_once 'includes/areaSearch.php';
                    getArea("infoFromThana()");
                    ?>
<input type="hidden" id="method" value="infoFromThana()">
    সার্চ/খুঁজুন:  <input type="text" id="search_box_filter">
                <?php }?>
    <?php
                if($input=='customer') {
                    include_once 'includes/areaSearch.php';
                    getArea("infoFromThana()");
                    ?>
<input type="hidden" id="method" value="infoFromThana()">
    সার্চ/খুঁজুন:  <input type="text" id="search_box_filter">
                <?php }?>
    <span id="office">
        <br/><br />
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo $showAccountType." নাম"; ?></th>
                        <th><?php echo $showAccountType."  অ্যাকাউন্ট নাম্বার"; ?></th>
                        <th><?php echo $showAccountType." ইমেইল"; ?></th>
                        <?php if($input == 'employee') {?>
                        <th><?php echo $showAccountType." মোবাইল নং"; ?></th>
                        <th><?php echo "অফিসের নাম"; ?></th>
                        
                        <?php } elseif ($input == 'proprietor') {?>
                        <th><?php echo "হেড পাওয়ারস্টোরের নাম"; ?></th>
                        
                            <?php } else {?>
                        <th><?php echo $showAccountType." মোবাইল নং"; ?></th>
                        <th><?php echo " থানা"; ?></th>
                        <?php }?>
                        <th><?php echo "করনীয়"; ?></th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php
                    if($input== 'proprietor')
                    {
                            $sql_officeTable = "SELECT * FROM cfs_user, proprietor_account WHERE user_type = 'owner' AND cfs_user_idUser = idUser";
                            $rs = mysql_query($sql_officeTable);
                                while ($row_officeNcontact = mysql_fetch_array($rs)) {
                                $db_Name = $row_officeNcontact['account_name'];
                                $db_accNumber = $row_officeNcontact['account_number'];
                                $db_email = $row_officeNcontact['email'];
                                $db_offName = $row_officeNcontact['powerStore_name'];
                                $db_proprietorID = $row_officeNcontact['idpropaccount'];
                                echo "<tr>";
                                echo "<td>$db_Name</td>";
                                echo "<td>$db_accNumber</td>";
                                echo "<td>$db_email</td>";
                                echo "<td>$db_offName</td>";
                                $v = base64_encode($db_proprietorID);
                                echo "<td><a href='update_proprietor_account.php?id=$v'>আপডেট</a></td>";
                                echo "</tr>";
                            }
                    }
                    elseif($input == 'employee'){
                        $sql_officeTable = "SELECT * from cfs_user,employee,ons_relation WHERE idons_relation=emp_ons_id AND (user_type='employee' OR user_type='programmer' OR user_type='presenter' OR user_type='trainer')
                                                        AND cfs_user_idUser= idUser ORDER BY account_name ASC";
                        $rs = mysql_query($sql_officeTable);
                            while ($row_officeNcontact = mysql_fetch_array($rs)) {
                            $db_Name = $row_officeNcontact['account_name'];
                            $db_accNumber = $row_officeNcontact['account_number'];
                            $db_email = $row_officeNcontact['email'];
                            $db_mobile = $row_officeNcontact['mobile'];
                            $db_empID = $row_officeNcontact['idEmployee'];
                            $db_onsType = $row_officeNcontact['catagory'];
                            $db_onsID = $row_officeNcontact['add_ons_id'];
                            if($db_onsType == 'office')
                            {
                                    $off_sel = mysql_query("SELECT * FROM office WHERE idOffice = $db_onsID");
                                    $offrow = mysql_fetch_assoc($off_sel);
                                    $onsName = $offrow['office_name'];
                            }
                            else 
                                {
                                    $off_sel = mysql_query("SELECT * FROM sales_store WHERE idSales_store = $db_onsID");
                                    $offrow = mysql_fetch_assoc($off_sel);
                                    $onsName = $offrow['salesStore_name'];
                                }
                            echo "<tr>";
                            echo "<td>$db_Name</td>";
                            echo "<td>$db_accNumber</td>";
                            echo "<td>$db_email</td>";
                            echo "<td>$db_mobile</td>";
                            echo "<td>$onsName</td>";
                            $v = base64_encode($db_empID);
                            echo "<td><a href='update_employee_account.php?id=$v'>আপডেট</a></td>";
                            echo "</tr>";
                        }
                    }
                     else{
                        $sql_officeTable = "SELECT * from cfs_user,customer_account,address,thana WHERE idThana=Thana_idThana AND address_whom='cust' AND address_type='Present' 
                                                        AND adrs_cepng_id= idCustomer_account AND cfs_user_idUser=idUser AND user_type='customer' ORDER BY account_name ASC";
                        $rs = mysql_query($sql_officeTable);
                            while ($row_officeNcontact = mysql_fetch_array($rs)) {
                            $db_Name = $row_officeNcontact['account_name'];
                            $db_accNumber = $row_officeNcontact['account_number'];
                            $db_email = $row_officeNcontact['email'];
                            $db_mobile = $row_officeNcontact['mobile'];
                            $db_thana = $row_officeNcontact['thana_name'];
                            $db_custID = $row_officeNcontact['idCustomer_account'];
                            echo "<tr>";
                            echo "<td>$db_Name</td>";
                            echo "<td>$db_accNumber</td>";
                            echo "<td>$db_email</td>";
                            echo "<td>$db_mobile</td>";
                            echo "<td>$db_thana</td>";
                           $v = base64_encode($db_custID);
                            echo "<td><a href='update_customer_account.php?id=$v'>আপডেট</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>                        
        </div>
    </span>          
</fieldset>
        </div>
            </div>
    </div>
</div>

<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
    });
</script>
<?php include_once 'includes/footer.php'; ?>