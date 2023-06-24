<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">{{ trans('labels.navigation') }}</li>
        <li class="treeview {{ Request::is('admin/dashboard') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/dashboard/this_month')}}">
            <i class="fa fa-dashboard"></i> <span>{{ trans('labels.header_dashboard') }}</span>
          </a>
        </li>
        <?php
          if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->view_media == 1){
        ?>
        <!-- <li class="treeview {{ Request::is('admin/media/add') ? 'active' : '' }} {{ Request::is('admin/media/display') ? 'active' : '' }} {{ Request::is('admin/addimages') ? 'active' : '' }} {{ Request::is('admin/uploadimage/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-picture-o"></i> <span>{{ trans('labels.media') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="treeview {{ Request::is('admin/media/add') ? 'active' : '' }} ">
                <a href="{{url('admin/media/add')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> {{ trans('labels.media') }} </span>
                </a>
            </li>

            <li class="treeview {{ Request::is('admin/media/display') ? 'active' : '' }} {{ Request::is('admin/addimages') ? 'active' : '' }} {{ Request::is('admin/uploadimage/*') ? 'active' : '' }} ">
                <a href="{{url('admin/media/display')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> {{ trans('labels.Media Setings') }} </span>
                </a>
            </li>
          </ul>
        </li> -->
        <?php } ?>
        <?php
          if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->view_state == 1){
        ?>
        <li class="treeview {{ Request::is('admin/states/display') ? 'active' : '' }} {{ Request::is('admin/states/add') ? 'active' : '' }} {{ Request::is('admin/states/edit/*') ? 'active' : '' }} {{ Request::is('admin/districts/display') ? 'active' : '' }} {{ Request::is('admin/districts/add') ? 'active' : '' }} {{ Request::is('admin/districts/edit/*') ? 'active' : '' }} {{ Request::is('admin/vidhan_sabhas/display') ? 'active' : '' }} {{ Request::is('admin/vidhan_sabhas/add') ? 'active' : '' }} {{ Request::is('admin/vidhan_sabhas/edit/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-picture-o"></i> <span>{{ trans('labels.Locations') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="treeview {{ Request::is('admin/states/display') ? 'active' : '' }} {{ Request::is('admin/states/add') ? 'active' : '' }} {{ Request::is('admin/states/edit/*') ? 'active' : '' }}">
                <a href="{{url('admin/states/display')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> {{ trans('labels.State') }} </span>
                </a>
            </li>

            <li class="treeview {{ Request::is('admin/districts/display') ? 'active' : '' }} {{ Request::is('admin/districts/add') ? 'active' : '' }} {{ Request::is('admin/districts/edit/*') ? 'active' : '' }} ">
                <a href="{{url('admin/districts/display')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> {{ trans('labels.District') }} </span>
                </a>
            </li>

            
            <li class="treeview {{ Request::is('admin/vidhan_sabhas/display') ? 'active' : '' }} {{ Request::is('admin/vidhan_sabhas/add') ? 'active' : '' }} {{ Request::is('admin/vidhan_sabhas/edit/*') ? 'active' : '' }} ">
                <a href="{{url('admin/vidhan_sabhas/display')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> {{ trans('labels.VidhanSabha') }} </span>
                </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php
          if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->view_mdf_user == 1){
        ?>
        <li class="treeview {{ Request::is('admin/mdf_users/display') ? 'active' : '' }} {{ Request::is('admin/states/add') ? 'active' : '' }} {{ Request::is('admin/states/edit/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-picture-o"></i> <span>{{ trans('labels.Accounts') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="treeview {{ Request::is('admin/mdf_users/display') ? 'active' : '' }} {{ Request::is('admin/states/add') ? 'active' : '' }} {{ Request::is('admin/states/edit/*') ? 'active' : '' }}">
                <a href="{{url('admin/mdf_users/display')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> {{ trans('labels.MDF') }} </span>
                </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php
          if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->view_media == 1){
        ?>
        <li class="treeview {{ Request::is('admin/wallets/csp/cspDisplay') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-picture-o"></i> <span>Wallets</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="treeview {{ Request::is('admin/wallets/csp/cspDisplay') ? 'active' : '' }}">
                <a href="{{url('admin/wallets/csp/cspDisplay')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> CSP </span>
                </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php
          // if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->view_media == 1){
        ?>
        <li class="treeview {{ Request::is('admin/money_transfer/mdfa_to_mdfa') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-picture-o"></i> <span>Money Transfer</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="treeview {{ Request::is('admin/money_transfer/mdfa_to_mdfa') ? 'active' : '' }}">
                <a href="{{url('admin/money_transfer/mdfa_to_mdfa')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> MDFA to MDFA </span>
                </a>
            </li>
          </ul>
        </li>
        <?php //} ?>
        <?php
          // if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->view_media == 1){
        ?>
        <li class="treeview {{ Request::is('admin/money_deposit/other_bank') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-picture-o"></i> <span>Money Deposit</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="treeview {{ Request::is('admin/money_deposit/other_bank') ? 'active' : '' }}">
                <a href="{{url('admin/money_deposit/other_bank')}}">
                    <i class="fa fa-circle-o" aria-hidden="true"></i> <span> Other Bank </span>
                </a>
            </li>
          </ul>
        </li>
        <?php //} ?>
        <?php

        if($result['commonContent']['roles']!= null and $result['commonContent']['roles']->manage_admins_view == 1){
      ?>

         <li class="treeview {{ Request::is('admin/admins') ? 'active' : '' }} {{ Request::is('admin/addadmins') ? 'active' : '' }} {{ Request::is('admin/editadmin/*') ? 'active' : '' }} {{ Request::is('admin/manageroles') ? 'active' : '' }} {{ Request::is('admin/addadminType') ? 'active' : '' }} {{ Request::is('admin/editadminType/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span> {{ trans('labels.Manage Admins') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>

          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/admins') ? 'active' : '' }} {{ Request::is('admin/addadmins') ? 'active' : '' }} {{ Request::is('admin/editadmin/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/admins')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_admins') }}</a></li>
            <li class="{{ Request::is('admin/manageroles') ? 'active' : '' }} {{ Request::is('admin/addadminType') ? 'active' : '' }} {{ Request::is('admin/editadminType/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/manageroles')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_manage_roles') }}</a></li>
          </ul>
        </li>
        <?php 
        }
        ?>
    </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
