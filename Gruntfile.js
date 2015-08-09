module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'symfony/vendor/bower',
                destPrefix: 'symfony/web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'font-awesome/fonts'
                }
            }
        },
        cssmin : {
            bootstrap:{
                src: 'symfony/web/assets/css/bootstrap.css',
                dest: 'symfony/web/assets/css/bootstrap.min.css'
            },
            "font-awesome":{
                src: 'symfony/web/assets/css/font-awesome.css',
                dest: 'symfony/web/assets/css/font-awesome.min.css'
            }
        },
        uglify : {
            js: {
                files: {
                    'symfony/web/assets/js/jquery.min.js': ['symfony/web/assets/js/jquery.js'],
                    'symfony/web/assets/js/bootstrap.min.js': ['symfony/web/assets/js/bootstrap.js']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['bowercopy', 'cssmin', 'uglify']);
};