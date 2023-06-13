<?php $uri = $this->uri->segment(2); ?>

<aside class="main-sidebar" id="alert2">   

    <section class="sidebar" id="sibe-box">
        <ul class="sidebar-menu verttop">

            <li class="treeview <?php if($uri == 'dashboard') { echo "active"; }?>">
                <a href="<?=base_url()?>dashboard">
                    <i class="fa fa-dashboard" aria-hidden="true"></i> <span> Dashboard</span>
                </a>
            </li>

            <li class="treeview <?php if($uri == 'leads') { echo "active"; }?>">
                <a href="<?=base_url()?>leads/list">
                    <i class="fas fa-list" aria-hidden="true"></i> <span> Leads</span>
                </a>
            </li>

            <li class="treeview <?php if($uri == 'users') { echo "active"; }?>">
                <a href="<?=base_url()?>users/list">
                    <i class="fas fa-users" aria-hidden="true"></i> <span> Users</span>
                </a>
            </li>

            <li class="treeview <?php if($uri == 'webdetails') { echo "active"; }?>">
                <a href="<?=base_url()?>webdetails">
                    <i class="fas fa-cog" aria-hidden="true"></i> <span> Settings</span>
                </a>
            </li>
          <li class="treeview ">
                <a href="">
                    <i class="fas fa-cog" aria-hidden="true"></i> <span> Settingskdhfksjfhjksdh</span>
                </a>
            </li>
         
        </ul>
    </section>             
</aside>			