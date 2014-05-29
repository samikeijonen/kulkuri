module.exports = function(grunt) {

	// 0. Load all tasks
	require( 'load-grunt-tasks' )( grunt );

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        /*concat: {
            // 2. Configuration for concatinating files goes here.
			dist: {
				src: [
					'js/fitvids/*.js',            // All JS in the fitvids folder
					//'js/fixed-nav/*.js',        // All JS in the fixed-nav folder
					'js/customizer.js',           // Customizer JS
					'js/skip-link-focus-fix.js',  // Skip link JS
				],
			dest: 'js/combined.js',
			}
        },*/
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
			fitvids: {
				files: {
					'js/fitvids/fitvids.min.js': ['js/fitvids/fitvids.js'],
					'js/fitvids/settings.min.js': ['js/fitvids/settings.js']
				}
			},
			theme: {
				files: {
					'js/skip-link-focus-fix.min.js': ['js/skip-link-focus-fix.js']
				}
			},
			customizer: {
				files:{
					'js/customizer.min.js': ['js/customizer.js']
				}
			}
		},
		cssmin : {
			css:{
				src: 'style.css',
				dest: 'style.min.css'
			}
		},
    	// https://www.npmjs.org/package/grunt-wp-i18n
		makepot: {
			target: {
				options: {
					domainPath: '/languages/',     // Where to save the POT file.
					potFilename: 'kulkuri.pot',    // Name of the POT file.
					type: 'wp-theme'               // Type of project (wp-plugin or wp-theme).
				}
			}
		}

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    //grunt.loadNpmTasks('grunt-contrib-concat');
	//grunt.loadNpmTasks('grunt-contrib-uglify');
	//grunt.loadNpmTasks('grunt-contrib-cssmin');
	//grunt.loadNpmTasks( 'grunt-wp-i18n' );

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask( 'default', ['uglify', 'cssmin', 'makepot'] );

};