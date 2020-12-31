<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
                    <i class="la la-close"></i>
                </button>
                <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
                    <!-- BEGIN: Aside Menu -->
                    <div  id="m_ver_menu" 
                          class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " 
                          m-menu-vertical="1"
                          m-menu-scrollable="0" m-menu-dropdown-timeout="500"  
                          >
                        <ul class="m-menu__nav ">
                            <li class="m-menu__section m-menu__section--first">
                                <h4 class="m-menu__section-text">
                                    Menu Items
                                </h4>
                                <i class="m-menu__section-icon flaticon-more-v3"></i>
                            </li>
                            <li class="m-menu__item  " aria-haspopup="true" >
                                <a  href="<?php echo base_url() ?>dashboard" class="m-menu__link">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                                    <span class="m-menu__link-text">
                                        Dashboard
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-clipboard"></i>
                                    <span class="m-menu__link-text">
                                        Masters
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="m-menu__submenu ">
                                    <span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
                                            <span class="m-menu__link">
                                                <span class="m-menu__item-here"></span>
                                                <span class="m-menu__link-text">
                                                    Applications
                                                </span>
                                            </span>
                                        </li>
                                        <li class="m-menu__item " aria-haspopup="true"  m-menu-link-redirect="1">
                                            <a  href="<?php echo base_url();?>master/manufacturer" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                    <span></span>
                                                </i>
                                                <span class="m-menu__link-text">
                                                    Vehicle Manufacturers
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item " aria-haspopup="true"  m-menu-link-redirect="1">
                                            <a  href="<?php echo base_url();?>master/state" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                    <span></span>
                                                </i>
                                                <span class="m-menu__link-text">
                                                    States
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item " aria-haspopup="true"  m-menu-link-redirect="1">
                                            <a  href="<?php echo base_url();?>master/city" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                    <span></span>
                                                </i>
                                                <span class="m-menu__link-text">
                                                    Cities
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-menu__item " aria-haspopup="true"  m-menu-link-redirect="1">
                                            <a  href="<?php echo base_url();?>master/engine" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                    <span></span>
                                                </i>
                                                <span class="m-menu__link-text">
                                                    Engines
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- END: Aside Menu -->
                </div>