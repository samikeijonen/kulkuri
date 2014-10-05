module.exports = function(grunt) {

	// Load all tasks
	require( 'load-grunt-tasks' )( grunt );

	// All configuration goes here 
	grunt.initConfig({
	pkg: grunt.file.readJSON('package.json'),
	
		// Minify files
		uglify: {
			nav: {
				files: {
					'js/fixed-nav/fastclick.min.js': ['js/fixed-nav/fastclick.js'],
					'js/fixed-nav/fixed-responsive-nav.min.js': ['js/fixed-nav/fixed-responsive-nav.js'],
					'js/fixed-nav/responsive-nav.min.js': ['js/fixed-nav/responsive-nav.js'],
					'js/fixed-nav/scroll.min.js': ['js/fixed-nav/scroll.js'],
					'js/fixed-nav/responsive-nav-settings.min.js': ['js/fixed-nav/responsive-nav-settings.js']
				}
			},
			fluidvids: {
				files: {
					'js/fluidvids/fluidvids.min.js': ['js/fluidvids/fluidvids.js'],
					'js/fluidvids/settings.min.js': ['js/fitvids/settings.js']
				}
			},
			customizer: {
				files:{
					'js/customizer.min.js': ['js/customizer.js']
				}
			},
			functions: {
				files:{
					'js/functions.min.js': ['js/functions.js']
				}
			}
		},
		cssmin : {
			css:{
				src: 'style.css',
				dest: 'style.min.css'
			},
			genericons: {
				src: 'fonts/genericons/genericons/genericons.css',
				dest: 'fonts/genericons/genericons/genericons.min.css'
			}
		},
		
		// Create pot file
		makepot: {
			target: {
				options: {
					domainPath: '/languages/',              // Where to save the POT file.
					exclude: ['build/.*', 'buildwpcom/.*'], // Exlude build folders.
					potFilename: 'kulkuri.pot',             // Name of the POT file.
					type: 'wp-theme'                        // Type of project (wp-plugin or wp-theme).
				}
			},
			targetwpcom: {
				options: {
					domainPath: '/languages/',                                  // Where to save the POT file.
					exclude: ['build/.*', 'buildwpcom/.*', 'theme-updater/.*'], // Exlude build folders and theme-updater folder.
					potFilename: 'kulkuriwpcom.pot',                            // Name of the POT file.
					type: 'wp-theme'                                            // Type of project (wp-plugin or wp-theme).
				}
			}
		},
		
		// Clean up build and buildwpcom directories
		clean: {
			main: ['build/<%= pkg.name %>'],
			mainwpcom: ['buildwpcom/<%= pkg.name %>']
		},

		// Copy the theme into the build directory and WP.com version to buildwpcom directory
		copy: {
			main: {
				src:  [
				'**',
				'!node_modules/**',
				'!build/**',
				'!buildwpcom/**',
				'!.git/**',
				'!Gruntfile.js',
				'!package.json',
				'!.gitignore',
				'!.gitmodules',
				'!.tx/**',
				'!**/Gruntfile.js',
				'!**/package.json',
				'!**/*~',
				'!languages/kulkuriwpcom.pot', // Do not include kulkuriwpcom.pot in WP.org version.
				],
				dest: 'build/<%= pkg.name %>/'
			},
			mainwpcom: {
				src:  [
				'**',
				'!node_modules/**',
				'!build/**',
				'!buildwpcom/**',
				'!.git/**',
				'!Gruntfile.js',
				'!package.json',
				'!.gitignore',
				'!.gitmodules',
				'!.tx/**',
				'!**/Gruntfile.js',
				'!**/package.json',
				'!**/*~',
				'!theme-updater/**',      // Do not include theme updater in WP.com version.
				'!style.min.css',         // Do not include style.min.css file.
				'!**/*.min.*',            // Do not include .min files.
				'!languages/kulkuri.pot', // Do not include kulkuri.pot in WP.com version.
				],
				dest: 'buildwpcom/<%= pkg.name %>/'
			}
		},
		
		// Replace text
		replace: {
			styleVersion: {
				src: [
					'style.css',
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				} ]
			},
			functionsVersion: {
				src: [
					'functions.php'
				],
				overwrite: true,
				replacements: [ {
					from: /^define\( 'KULKURI_VERSION'.*$/m,
					to: 'define( \'KULKURI_VERSION\', \'<%= pkg.version %>\' );'
				} ]
			},
			tags: {
				src: [
					'buildwpcom/<%= pkg.name %>/style.css'
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Tags:.*$/m,
					to: 'Tags: green, white, light, one-column, fluid-layout, responsive-layout, custom-background, custom-header, custom-menu, editor-style, featured-images, flexible-header, threaded-comments, translation-ready, infinite-scroll, announcement, business, portfolio, bright, clean, light, modern, playful, professional, tech'
				} ]
			},
			themeuri: {
				src: [
					'buildwpcom/<%= pkg.name %>/style.css'
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Theme URI:.*$/m,
					to: 'Theme URI: http://theme.wordpress.com/themes/kulkuri/'
				} ]
			}
		},

		// Compress build directory into <name>.zip and <name>-<version>.zip
		compress: {
			main: {
				options: {
				mode: 'zip',
				archive: './build/<%= pkg.name %>_v<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'build/<%= pkg.name %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			},
			mainwpcom: {
				options: {
				mode: 'zip',
				archive: './buildwpcom/<%= pkg.name %>_v<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'buildwpcom/<%= pkg.name %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		},

    });

	// What to do when we type "grunt" into the terminal.
	grunt.registerTask( 'default', ['uglify', 'cssmin'] );
	
	// Build task(s).
	grunt.registerTask( 'build', [ 'makepot', 'clean', 'replace:styleVersion', 'replace:functionsVersion', 'copy', 'replace:tags', 'replace:themeuri', 'compress' ] );

};