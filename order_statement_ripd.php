<?php
include_once 'includes/MiscFunctions.php';
include 'includes/ConnectDB.inc';
include 'includes/header.php';
?>
<style type="text/css">
    @import "css/bush.css";
    .formstyle td{
        padding: 0px;
        text-align: center;
    }
</style>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="index.php?apps=ALO"><b>ফিরে যান</b></a></div> 
        <div>         
            <form>
                <table  class="formstyle">   
                    <tr><th colspan="9" style="text-align: center;">অর্ডার স্টেটমেন্ট</th></tr> 
                    <tr  id="table_row_odd">
                        <td>তারিখ</td>
                        <td>সময়</td>
                        <td>অর্ডার নং</td>
                        <td>একাউন্ট নং</td>
                        <td>অর্ডার এমাউন্ট</td>
                    </tr> 
                    <tr>
                        <td>০২-০৩-১৩</td>
                        <td>৮.৪৫ এ. এম.</td>
                        <td>৪</td>
                        <td>AC-১৩৪২৩৪৩৪</td>
                        <td>২</td>
                    </tr>                                    
                    <tr>
                        <td>০৬-০৩-১৩</td>
                        <td>৮.৪৫ এ. এম.</td>
                        <td>৫</td>
                        <td>AC-৪২৩৪৩৪</td>
                        <td>৩২</td>
                    </tr>                                       
                </table>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>