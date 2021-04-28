<?php

if ($roleuser == 3) {
    ?>
    <li>
        <a href="vw_ticket.php">
            <i class="material-icons">local_play</i>
            <p>Ticketing</p>
        </a>
    </li>
    <li>
        <a href="vw_ticket_manager.php">
            <i class="material-icons">assignment</i>
            <p>Ticket Management</p>
        </a>
    </li>
    <li>
        <a href="vw_mapping.php">
            <i class="material-icons">assignment_ind</i>
            <p>PIC Management</p>
        </a>
    </li>
    <li>
        <a href="vw_role.php">
            <i class="material-icons">how_to_reg</i>
            <p>User Management</p>
        </a>
    </li>
    <li>
        <a href="vw_divisi.php">
            <i class="material-icons">group_add</i>
            <p>Divisi</p>
        </a>
    </li>
    <li>
        <a href="vw_category.php">
            <i class="material-icons">library_books</i>
            <p>Category</p>
        </a>
    </li>
    <li>
        <a href="vw_category_det.php">
            <i class="material-icons">format_list_bulleted</i>
            <p>Detail Category</p>
        </a>
    </li>
    <li>
        <a href="vw_report.php">
            <i class="material-icons">move_to_inbox</i>
            <p>Report Ticket</p>
        </a>
    </li>
    <li> 
        <a data-toggle="collapse" href="#vw_digital_form" class="collapsed">       
            <i class="material-icons">assignment</i>
            <p>Digital Form</p>
        </a>
        <div class="collapse" id="vw_digital_form">
            <ul class="nav">
                <li>
                    <a href="vw_form_Aplikasi.php">
                    <i class="material-icons">apps</i>
                    <p>Form Request Aplikasi</p>
                    </a>
                </li>
                <li>   
                    <a href="vw_form_vpn.php">
                    <i class="material-icons">vpn_key</i>
                    <p>Form Request VPN</p>
                    </a>
                </li>
                <li>       
                    <a href="vw_form_email.php">
                    <i class="material-icons">email</i>
                    <p>Form Request Email</p>
                    </a>
                </li>    
            </ul>
        </div>        
    </li>

    <?php
} else if ($roleuser == 2) {
    ?>
    <li>
        <a href="vw_ticket_manager.php">
            <i class="material-icons">assignment</i>
            <p>Ticket Management</p>
        </a>
    </li>
    <li>
        <a href="vw_ticket.php">
            <i class="material-icons">local_play</i>
            <p>Input Ticketing</p>
        </a>
    </li>
    <li> 
        <a data-toggle="collapse" href="#vw_digital_form" class="collapsed">       
            <i class="material-icons">assignment</i>
            <p>Digital Form</p>
        </a>
        <div class="collapse" id="vw_digital_form">
            <ul class="nav">
                <li>
                    <a href="vw_form_Aplikasi.php">
                    <i class="material-icons">apps</i>
                    <p>Form Request Aplikasi</p>
                    </a>
                </li>
                <li>   
                    <a href="vw_form_vpn.php">
                    <i class="material-icons">vpn_key</i>
                    <p>Form Request VPN</p>
                    </a>
                </li>
                <li>       
                    <a href="vw_form_email.php">
                    <i class="material-icons">email</i>
                    <p>Form Request Email</p>
                    </a>
                </li>    
            </ul>
        </div>        
    </li>

    <?php
} else {
    ?>
    <li>
        <a href="vw_ticket.php">
            <i class="material-icons">local_play</i>
            <p>Ticketing</p>
        </a>
    </li>
    <?php
}
?>