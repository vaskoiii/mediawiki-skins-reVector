<?php
/**
 * Vector - Modern version of MonoBook with fresh look and many usability
 * improvements.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Skins
 */

/**
 * QuickTemplate class for Vector skin
 * @ingroup Skins
 */
class VectorTemplate extends BaseTemplate {
	/* Functions */

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {
		// Build additional attributes for navigation urls
		$nav = $this->data['content_navigation'];

		if ( $this->config->get( 'VectorUseIconWatch' ) ) {
			$mode = $this->getSkin()->getUser()->isWatched( $this->getSkin()->getRelevantTitle() )
				? 'unwatch'
				: 'watch';

			if ( isset( $nav['actions'][$mode] ) ) {
				$nav['views'][$mode] = $nav['actions'][$mode];
				$nav['views'][$mode]['class'] = rtrim( 'icon ' . $nav['views'][$mode]['class'], ' ' );
				$nav['views'][$mode]['primary'] = true;
				unset( $nav['actions'][$mode] );
			}
		}

		$xmlID = '';
		foreach ( $nav as $section => $links ) {
			foreach ( $links as $key => $link ) {
				if ( $section == 'views' && !( isset( $link['primary'] ) && $link['primary'] ) ) {
					$link['class'] = rtrim( 'collapsible ' . $link['class'], ' ' );
				}

				$xmlID = isset( $link['id'] ) ? $link['id'] : 'ca-' . $xmlID;
				$nav[$section][$key]['attributes'] =
					' id="' . Sanitizer::escapeId( $xmlID ) . '"';
				if ( $link['class'] ) {
					$nav[$section][$key]['attributes'] .=
						' class="' . htmlspecialchars( $link['class'] ) . '"';
					unset( $nav[$section][$key]['class'] );
				}
				if ( isset( $link['tooltiponly'] ) && $link['tooltiponly'] ) {
					$nav[$section][$key]['key'] =
						Linker::tooltip( $xmlID );
				} else {
					$nav[$section][$key]['key'] =
						Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( $xmlID ) );
				}
			}
		}
		$this->data['namespace_urls'] = $nav['namespaces'];
		$this->data['view_urls'] = $nav['views'];
		$this->data['action_urls'] = $nav['actions'];
		$this->data['variant_urls'] = $nav['variants'];

		// Reverse horizontally rendered navigation elements
		if ( $this->data['rtl'] ) {
			$this->data['view_urls'] =
				array_reverse( $this->data['view_urls'] );
			$this->data['namespace_urls'] =
				array_reverse( $this->data['namespace_urls'] );
			$this->data['personal_urls'] =
				array_reverse( $this->data['personal_urls'] );
		}

		$this->data['pageLanguage'] =
			$this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();

		// Output HTML Page
		$this->html( 'headelement' );
		?>
		<div id="mw-page-base" class="noprint"></div>
		<div id="mw-head-base" class="noprint"></div>

		<div id="whoami">
			<style>
				#whoami {
					position: absolute;
					top: 2px;
					font-size: small;
					right: 10px; }
			</style>
			<?
			# todo better way to get this?
			$a1 = $this->getPersonalTools();
			if (!empty($a1['userpage']['links'][0]['text']))
				echo htmlentities($a1['userpage']['links'][0]['text']);
			else
				echo htmlentities($_SERVER['REMOTE_ADDR']);
			?>
		</div>

                <style> 
                        /* table stuff */
                        th,
                        td {
                                border: 1px solid #aaa;
                                border-bottom: none;
                                display: block; }
                        tr {
                                margin-bottom: 10px;
                                margin-right: 10px;
                                display: block;
                                float: left;
                                border: none;
                                border-bottom: 1px solid #aaa; }
			<? # use <table> only for attribute/value pairs (not layout) ie. spreadsheets ?>
			<? # the : serves as a reminder to use data-x="attribute" (even with plain html) ?>
                        td:before {
                                content: attr(data-x) ": ";
                                font-size: 75%; }
                        table.wikitable,
                        table.mw-datatable,
                        table {
                                min-width: 0px;
                                margin-top: 15px;
                                margin-bottom: 0px;
                                border: none;
                                background-color: transparent; }
                        .prefsection td.mw-label {
                                width: auto; }
                        .mw-label {
                                text-align: left;
                                font-size: 75%;
                                color: #333; }
                                td.mw-label {
                                        text-align: left; }
                        .mw-page-info td:before,
                        fieldset td:before {
                                content: '';}
                                .wikitable.mw-page-info td {
                                        border: none; }
                                .wikitable.mw-page-info tr {
                                        border: 1px solid #aaa; }
                        fieldset tr,
                        fieldset td {
                                border: none; }
                </style><?
		# if edits are for a specific page mention it in a php comment
		# (with irrelevant variables renamed starting with: a b c ...) ?> 
		<style>
			table.mw_metadata {
				width: 100%; }
			.fullImageLink img {
				max-width: 100%;
				height: auto; }
			.floatleft,
			.floatright {
				max-width: 100%; }
				.image img {
					max-width: 100%;
					height: auto; }
			.printfooter {
				clear: both; }
			<? # /index.php?title=a&diff=b&oldid=c ?> 
			table.diff {
				table-layout: auto; }
			table.diff col.diff-content,
			table.diff col.diff-marker {
				width: auto; }
			td.diff-marker {
				display: none; }
			td.diff-context,
			td.diff-deletedline,
			td.diff-addedline {
				border-radius: 0; }
			td.diff-context {
				border: 1px solid #ccc; }
			table.diff td div {
				display: inline-block; }
			<? # /File:a.png >> Show extended details ?> 
			td ul.metadata-langlist {
				display: inline-block; }
			<? # /Special:Preferences ?> 
			#preferences fieldset td.mw-label {
				width: auto; }
			<? # /Special:ListFiles?limit=1 ?> 
			<? # override style="width: 25%" with !important ?> 
			td.TablePager_nav-first ,
			td.TablePager_nav-prev ,
			td.TablePager_nav-next ,
			td.TablePager_nav-last {
				border-bottom: 1px solid #aaa;
				display: inline-block;
				width: auto !important; }
			td.TablePager_nav-first div ,
			td.TablePager_nav-prev div ,
			td.TablePager_nav-next div ,
			td.TablePager_nav-last div {
				display: inline-block; }
			.TablePager_nav tr {
				margin-bottom: 0px;
				border: 0px; }
			.TablePager_nav {
				width: 100%; }
		</style>
                <style>
                        /* non-table stuff */
                        .mw-body {
                                10px; }
                        select,
                        input {
                                max-width: 250px; }

                        legend {
                                padding-left: 0px; }
			pre,
                        code {
                                word-wrap: break-word; }
                        .movepage-wrapper {
                                width: auto; }
                        #mw-htmlform-tokenwatchlist .mw-input {
                                /* watchlist token */
                                word-wrap: break-word;
                                word-break: break-word;
                                white-space: pre-line;
                                width: 250px;
                                }
                </style>
		<style>
			/* enable wrapping for login pages */
			.mw-input-with-label {
				white-space: normal; }
		</style>
                <style><?
                        # keep last to do overrides
                        $a1 = array(
                                # x < 1000
                                200,
                                240,
                                288,
                                320,
                                352,
                                384,
                                480,
                                576,
                                600,
                                640,
                                720,
                                768,
                                800,
                                854,
                                864,
                                900,
                                960,
                                # x >= 1000
                                1024,
                                1050,
                                1080,
                                1152,
                                1200,
                                1280,
                                1366,
                                1400,
                                1440,
                                1536,
                                1600,
                                1680,
                                1920,
                                2048,
                                2160,
                                2560,
                                3440,
                                3840,
                                4096,
                        );
			# use minimal css and minify
			foreach ($a1 as $k1 => $v1) {
				echo "\n" . '@media (min-width:' . (int)$v1 . 'px) { ' .
					'table.t' . (int)$v1 . 'px { ' .
						'margin-bottom: 15px; } ' .
					'.t' . (int)$v1 . 'px th, ' .
					'.t' . (int)$v1 . 'px td { ' .
						'display: table-cell; } ' .
					'.t' . (int)$v1 . 'px tr { ' .
						'display: table-row; ' .
						'float: none; } ' .
					'.t' . (int)$v1 . 'px td:before { ' .
						'content: ""; } ' .
				'} ';
			} ?> 
                </style>

		<script>
			function mVectorToggle() {
				var o1 = document.getElementById('mw-navigation');
				var o2 = document.getElementById('mVectorToggle');
				switch(o1.style.display) {
					case 'block':
						o1.style.display = 'none';
						o2.innerHTML = 'More';
					break;
					default:
						o1.style.display = 'block';
						o2.innerHTML = 'Less';
					break;
				}
			}
		</script>

                <style>
			#footer {
				margin-top: 20px; }
                        .emptyPortlet {
                                display: none; }
                        #mVectorLogo {
                                font-size: 32px;
                                margin-right: 10px; }
                                #mVectorLogo img {
                                        width: auto;
                                        height: 48px;
                                        /* border: 1px solid green; */
                                        margin: 0px 10px 10px 0px;
                                        }
                        #mVectorSearchForm {
                                display: inline-block;
                                }
                        #mw-indicator-mw-helplink {
                                display: none;
                                }
                        #mVectorSearchInput {
                                width: 175px; }
                        .mFloater {
                                float: left; }
                </style>
                <div id="p-search" role="search">
                        <form action="<?php $this->text( 'wgScript' ) ?>" id="mVectorSearchForm">
                                <div style="display: inline;"><?
                                        # setup logo title and style that will appear on all pages here ?> 
                                        <a id="mVectorLogo" class="mFloater" href="/"
                                                ><img src="<?= $this->get('logopath'); ?>" alt=""
                                                /><?= $this->html('sitename'); ?></a>
                                </div>
                                <br clear="all" />

				<?/* <span<?php echo $this->config->get( 'VectorUseSimpleSearch' ) ? ' id="simpleSearch"' : '' ?>> */?>
				<?php
				echo $this->makeSearchInput(
					array(
						'id' => 'mVectorSearchInput',
						'class' => 'mFloater',
					)
				);
				echo Html::hidden( 'title', $this->get( 'searchtitle' ) );
				echo $this->makeSearchButton(
					'go',
					array(
						'id' => 'searchButton',
						'class' => 'searchButton mFloater',
					 )
				); ?> 
				<?/* </span> */?>
				<div class="mFloater" style="margin: 2px 0px 0px 5px;">
					<span style="color: #777;">::</span> <a href="#" id="mVectorToggle" onclick="mVectorToggle(); return false;">More</a>
				</div>
			</form>
			<br clear="all" />
		</div>
		<div id="mw-navigation" style="display: none;">
			<h2><?php $this->msg( 'navigation-heading' ) ?></h2>

			<div id="mw-head">
				<?php $this->renderNavigation( 'PERSONAL' ); ?>
				<div id="left-navigation">
					<?php $this->renderNavigation( array( 'NAMESPACES', 'VARIANTS' ) ); ?>
				</div>
				<div id="right-navigation">
					<?php $this->renderNavigation( array( 'VIEWS', 'ACTIONS', 'SEARCH' ) ); ?>
				</div>
			</div>
			<div id="mw-panel">
				<div id="p-logo" role="banner"><a class="mw-wiki-logo" href="<?php
					echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] )
					?>" <?php
					echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) )
					?>></a></div>
				<?php $this->renderPortals( $this->data['sidebar'] ); ?>
			</div>
		</div>









		<div id="content" class="mw-body" role="main">
			<a id="top"></a>

			<?php
			if ( $this->data['sitenotice'] ) {
				?>
				<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
			<?php
			}
			?>
			<?php
			if ( is_callable( [ $this, 'getIndicators' ] ) ) {
				echo $this->getIndicators();
			}
			// Loose comparison with '!=' is intentional, to catch null and false too, but not '0'
			if ( $this->data['title'] != '' ) {
			?>
			<h1 id="firstHeading" class="firstHeading" lang="<?php $this->text( 'pageLanguage' ); ?>"><?php
				 $this->html( 'title' )
			?></h1>
			<?php
			} ?>
			<?php $this->html( 'prebodyhtml' ) ?>
			<div id="bodyContent" class="mw-body-content">
				<?php
				if ( $this->data['isarticle'] ) {
					?>
					<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>
				<?php
				}
				?>
				<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php
					$this->html( 'subtitle' )
				?></div>
				<?php
				if ( $this->data['undelete'] ) {
					?>
					<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
				<?php
				}
				?>
				<?php
				if ( $this->data['newtalk'] ) {
					?>
					<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
				<?php
				}
				/*
				?>
				<div id="jump-to-nav" class="mw-jump">
					<?php $this->msg( 'jumpto' ) ?>
					<a href="#mw-head"><?php
						$this->msg( 'jumptonavigation' )
					?></a><?php $this->msg( 'comma-separator' ) ?>
					<a href="#p-search"><?php $this->msg( 'jumptosearch' ) ?></a>
				</div>
				<?php
				*/
				$this->html( 'bodycontent' );

				if ( $this->data['printfooter'] ) {
					?>
					<div class="printfooter">
						<?php $this->html( 'printfooter' ); ?>
					</div>
				<?php
				}

				if ( $this->data['catlinks'] ) {
					$this->html( 'catlinks' );
				}

				if ( $this->data['dataAfterContent'] ) {
					$this->html( 'dataAfterContent' );
				}
				?>
				<div class="visualClear"></div>
				<?php $this->html( 'debughtml' ); ?>
			</div>
		</div>
		<div id="footer" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
			<?php
			foreach ( $this->getFooterLinks() as $category => $links ) {
				?>
				<ul id="footer-<?php echo $category ?>">
					<?php
					foreach ( $links as $link ) {
						?>
						<li id="footer-<?php echo $category ?>-<?php echo $link ?>"><?php $this->html( $link ) ?></li>
					<?php
					}
					?>
				</ul>
			<?php
			}
			?>
			<?php $footericons = $this->getFooterIcons( 'icononly' );
			if ( count( $footericons ) > 0 ) {
				?>
				<ul id="footer-icons" class="noprint">
					<?php
					foreach ( $footericons as $blockName => $footerIcons ) {
						?>
						<li id="footer-<?php echo htmlspecialchars( $blockName ); ?>ico">
							<?php
							foreach ( $footerIcons as $icon ) {
								echo $this->getSkin()->makeFooterIcon( $icon );
							}
							?>
						</li>
					<?php
					}
					?>
				</ul>
			<?php
			}
			?>
			<div style="clear:both"></div>
		</div>
		<?php $this->printTrail(); ?>

	</body>
</html>
<?php
	}

	/**
	 * Render a series of portals
	 *
	 * @param array $portals
	 */
	protected function renderPortals( $portals ) {
		// Force the rendering of the following portals
		if ( !isset( $portals['SEARCH'] ) ) {
			$portals['SEARCH'] = true;
		}
		if ( !isset( $portals['TOOLBOX'] ) ) {
			$portals['TOOLBOX'] = true;
		}
		if ( !isset( $portals['LANGUAGES'] ) ) {
			$portals['LANGUAGES'] = true;
		}
		// Render portals
		foreach ( $portals as $name => $content ) {
			if ( $content === false ) {
				continue;
			}

			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;

			switch ( $name ) {
				case 'SEARCH':
					break;
				case 'TOOLBOX':
					$this->renderPortal( 'tb', $this->getToolbox(), 'toolbox', 'SkinTemplateToolboxEnd' );
					break;
				case 'LANGUAGES':
					if ( $this->data['language_urls'] !== false ) {
						$this->renderPortal( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
				default:
					$this->renderPortal( $name, $content );
					break;
			}
		}
	}

	/**
	 * @param string $name
	 * @param array $content
	 * @param null|string $msg
	 * @param null|string|array $hook
	 */
	protected function renderPortal( $name, $content, $msg = null, $hook = null ) {
		if ( $msg === null ) {
			$msg = $name;
		}
		$msgObj = wfMessage( $msg );
		$labelId = Sanitizer::escapeId( "p-$name-label" );
		?>
		<div class="portal" role="navigation" id='<?php
		echo Sanitizer::escapeId( "p-$name" )
		?>'<?php
		echo Linker::tooltip( 'p-' . $name )
		?> aria-labelledby='<?php echo $labelId ?>'>
			<h3<?php $this->html( 'userlangattributes' ) ?> id='<?php echo $labelId ?>'><?php
				echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $msg );
				?></h3>

			<div class="body">
				<?php
				if ( is_array( $content ) ) {
					?>
					<ul>
						<?php
						foreach ( $content as $key => $val ) {
							echo $this->makeListItem( $key, $val );
						}
						if ( $hook !== null ) {
							Hooks::run( $hook, [ &$this, true ] );
						}
						?>
					</ul>
				<?php
				} else {
					echo $content; /* Allow raw HTML block to be defined by extensions */
				}

				$this->renderAfterPortlet( $name );
				?>
			</div>
		</div>
	<?php
	}

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 *
	 * @param array $elements
	 */
	protected function renderNavigation( $elements ) {
		// If only one element was given, wrap it in an array, allowing more
		// flexible arguments
		if ( !is_array( $elements ) ) {
			$elements = [ $elements ];
			// If there's a series of elements, reverse them when in RTL mode
		} elseif ( $this->data['rtl'] ) {
			$elements = array_reverse( $elements );
		}
		// Render elements
		foreach ( $elements as $name => $element ) {
			switch ( $element ) {
				case 'NAMESPACES':
					?>
					<div id="p-namespaces" role="navigation" class="vectorTabs<?php
					if ( count( $this->data['namespace_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-namespaces-label">
						<h3 id="p-namespaces-label"><?php $this->msg( 'namespaces' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							foreach ( $this->data['namespace_urls'] as $link ) {
								?>
								<li <?php echo $link['attributes'] ?>><span><a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" <?php
										echo $link['key'];
										if ( isset ( $link['rel'] ) ) {
											echo ' rel="' . htmlspecialchars( $link['rel'] ) . '"';
										}
										?>><?php
											echo htmlspecialchars( $link['text'] )
											?></a></span></li>
							<?php
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'VARIANTS':
					?>
					<div id="p-variants" role="navigation" class="vectorMenu<?php
					if ( count( $this->data['variant_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-variants-label">
						<?php
						// Replace the label with the name of currently chosen variant, if any
						$variantLabel = $this->getMsg( 'variants' )->text();
						foreach ( $this->data['variant_urls'] as $link ) {
							if ( stripos( $link['attributes'], 'selected' ) !== false ) {
								$variantLabel = $link['text'];
								break;
							}
						}
						?>
						<h3 id="p-variants-label">
							<span><?php echo htmlspecialchars( $variantLabel ) ?></span><a href="#"></a>
						</h3>

						<div class="menu">
							<ul>
								<?php
								foreach ( $this->data['variant_urls'] as $link ) {
									?>
									<li<?php echo $link['attributes'] ?>><a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" lang="<?php
										echo htmlspecialchars( $link['lang'] )
										?>" hreflang="<?php
										echo htmlspecialchars( $link['hreflang'] )
										?>" <?php
										echo $link['key']
										?>><?php
											echo htmlspecialchars( $link['text'] )
											?></a></li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
					<?php
					break;
				case 'VIEWS':
					?>
					<div id="p-views" role="navigation" class="vectorTabs<?php
					if ( count( $this->data['view_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-views-label">
						<h3 id="p-views-label"><?php $this->msg( 'views' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							foreach ( $this->data['view_urls'] as $link ) {
								?>
								<li<?php echo $link['attributes'] ?>><span><a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" <?php
										echo $link['key'];
										if ( isset ( $link['rel'] ) ) {
											echo ' rel="' . htmlspecialchars( $link['rel'] ) . '"';
										}
										?>><?php
											// $link['text'] can be undefined - bug 27764
											if ( array_key_exists( 'text', $link ) ) {
												echo array_key_exists( 'img', $link )
													? '<img src="' . $link['img'] . '" alt="' . $link['text'] . '" />'
													: htmlspecialchars( $link['text'] );
											}
											?></a></span></li>
							<?php
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'ACTIONS':
					?>
					<div id="p-cactions" role="navigation" class="vectorMenu<?php
					if ( count( $this->data['action_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-cactions-label">
						<h3 id="p-cactions-label"><span><?php
							$this->msg( 'vector-more-actions' )
						?></span><a href="#"></a></h3>

						<div class="menu">
							<ul<?php $this->html( 'userlangattributes' ) ?>>
								<?php
								foreach ( $this->data['action_urls'] as $link ) {
									?>
									<li<?php echo $link['attributes'] ?>>
										<a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" <?php
										echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] )
											?></a>
									</li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
					<?php
					break;
				case 'PERSONAL':
					?>
					<div id="p-personal" role="navigation" class="<?php
					if ( count( $this->data['personal_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-personal-label">
						<h3 id="p-personal-label"><?php $this->msg( 'personaltools' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							$personalTools = $this->getPersonalTools();
							foreach ( $personalTools as $key => $item ) {
								echo $this->makeListItem( $key, $item );
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'SEARCH':
/*
					?>
					<div id="p-search" role="search">
						<h3<?php $this->html( 'userlangattributes' ) ?>>
							<label for="searchInput"><?php $this->msg( 'search' ) ?></label>
						</h3>

						<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
							<div<?php echo $this->config->get( 'VectorUseSimpleSearch' ) ? ' id="simpleSearch"' : '' ?>>
							<?php
							echo $this->makeSearchInput( [ 'id' => 'searchInput' ] );
							echo Html::hidden( 'title', $this->get( 'searchtitle' ) );
							// We construct two buttons (for 'go' and 'fulltext' search modes),
							// but only one will be visible and actionable at a time (they are
							// overlaid on top of each other in CSS).
							// * Browsers will use the 'fulltext' one by default (as it's the
							//   first in tree-order), which is desirable when they are unable
							//   to show search suggestions (either due to being broken or
							//   having JavaScript turned off).
							// * The mediawiki.searchSuggest module, after doing tests for the
							//   broken browsers, removes the 'fulltext' button and handles
							//   'fulltext' search itself; this will reveal the 'go' button and
							//   cause it to be used.
							echo $this->makeSearchButton(
								'fulltext',
								[ 'id' => 'mw-searchButton', 'class' => 'searchButton mw-fallbackSearchButton' ]
							);
							echo $this->makeSearchButton(
								'go',
								[ 'id' => 'searchButton', 'class' => 'searchButton' ]
							);
							?>
							</div>
						</form>
					</div>
					<?php
*/

					break;
			}
		}
	}
}
