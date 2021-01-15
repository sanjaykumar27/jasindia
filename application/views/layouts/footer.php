</div>
<div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
											<div class="m-quick-sidebar__content m--hide">
												<span id="m_quick_sidebar_close" class="m-quick-sidebar__close">
													<i class="la la-close"></i>
												</span>
												<ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
													<li class="nav-item m-tabs__item">
														<a class="nav-link m-tabs__link font-weight-bold pt-0" data-toggle="tab" href="#m_quick_sidebar_tabs_logs" role="tab">
															Audit Logs
														</a>
													</li>
												</ul>
												<div class="tab-content">
													<div class="tab-pane active" id="m_quick_sidebar_tabs_logs" role="tabpanel">
														<div class="m-list-timeline m-scrollable">
															<div class="m-list-timeline__group">
																<div class="m-list-timeline__items">
																	<?php if(!empty($audit_logs)) {
																		foreach($audit_logs as $value) { ?>
																			<div class="m-list-timeline__item">
																				<span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
																				<a href="javascript:void(0)" class="m-list-timeline__text font-weight-bold">
																					<?php echo $value->record; ?>
																					<p class="small mb-0 text-warning"><?php echo $value->page. ' | By: '.$value->first_name.' '.$value->last_name ?></p>
																				</a>
																				<span class="m-list-timeline__time font-weight-bold font-italics">
																				<?php echo get_time_ago( strtotime($value->created_on) ); ?>
																				</span>
																				
																			</div>
																<?php } } ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
<footer class="m-grid__item		m-footer ">
                <div class="m-container m-container--fluid m-container--full-height m-page__container">
                    <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                        <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                            <span class="m-footer__copyright">
                                2020 &copy; Jas India
                                <a href="javascript:void(0)" class="m-link">
                                    All Rights Reserved
                                </a>
                            </span>
                        </div>
                        <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                            <ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
                                <li class="m-nav__item">
                                    <a href="#" class="m-nav__link">
                                        <span class="m-nav__link-text">
                                            About
                                        </span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="#"  class="m-nav__link">
                                        <span class="m-nav__link-text">
                                            Privacy
                                        </span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="#" class="m-nav__link">
                                        <span class="m-nav__link-text">
                                            T&C
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end::Footer -->
        </div>

		<?php 
			function get_time_ago( $time )
			{
				$time_difference = time() - $time;
			
				if( $time_difference < 1 ) { return '1 second ago'; }
				$condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
							30 * 24 * 60 * 60       =>  'month',
							24 * 60 * 60            =>  'day',
							60 * 60                 =>  'hour',
							60                      =>  'minute',
							1                       =>  'second'
				);
			
				foreach( $condition as $secs => $str )
				{
					$d = $time_difference / $secs;
			
					if( $d >= 1 )
					{
						$t = round( $d );
						return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
					}
				}
			}
		?>

        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>
        <!-- end::Scroll Top -->		    <!-- begin::Quick Nav -->

        <!-- end:: Page -->
        <!--begin::Base Scripts -->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
        <script src="<?php echo base_url();?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
        <!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
        <script src="<?php echo base_url();?>assets/snippets/custom/pages/user/login.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/custom.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/jquery.blockUI.js" type="text/javascript"></script>
        <!--end::Page Snippets -->
    </body>
    <!-- end::Body -->
</html>