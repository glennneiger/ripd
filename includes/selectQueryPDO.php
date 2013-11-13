<?php
include 'connectionPDO.php';
$sql_select_command = $conn->prepare("SELECT * FROM command ORDER BY commandno ASC");
$sql_select_account_type = $conn->prepare("SELECT idAccount_type, account_name FROM account_type LIMIT 5");
$sql_pv_view = $conn->prepare("SELECT
                                                                    cust_type, sales_type, store_type, less_amount, selling_earn, patent_nh,
                                                                    pv_ripd_income, direct_sales_cust, account_name, Rone, Rtwo, Rthree, Rfour, Rfive,
                                                                    office, staff, shariah, charity, presentation, training, program, travel, patent, leadership, transport, research, server, bag, brochure, form, money_receipt, pad, box, extra
                                                                        FROM view_pv_view WHERE idcommand=?
                                                                                ORDER BY cust_type ASC");
$sql_current_command = $conn->prepare("SELECT * FROM running_command LIMIT 1");
?>
