//let mix = require('laravel-mix');
//const path = require('path');
//let directory = path.basename(path.resolve(__dirname));
//
//const source = 'platform/plugins/' + directory;
//const dist = 'public/vendor/core/plugins/' + directory;
//const kycPublic = source + '/public/assets/js';
//
//// Define scripts to compile
//const scripts = [
//    'edit-kyc.js',
//    'kyc-admin.js',
//];
//
//// Compile scripts
//scripts.forEach(item => {
//    mix.js(source + '/resources/assets/js/' + item, dist + '/js');
//});
//
//// Copy compiled files to appropriate locations
//mix.then(() => {
//    // Also copy kyc-admin.js to platform/plugins/kyc/public/assets/js
//    mix.copy(dist + '/js/kyc-admin.js', kycPublic);
//});
//
//if (mix.inProduction()) {
//    scripts.forEach(item => {
//        mix.copy(dist + '/js/' + item, source + '/public/js');
//        if (item === 'kyc-admin.js') {
//            mix.copy(dist + '/js/' + item, kycPublic);
//        }
//    });
//}
//
//// Styles
//const styles = [
//    'palette-variables.scss',
//];
//
//styles.forEach(item => {
//    mix.sass(source + '/resources/assets/sass/' + item, dist + '/css');
//});
//
//if (mix.inProduction()) {
//    styles.forEach(item => {
//        mix.copy(dist + '/css/' + item.replace('.scss', '.css'), source + '/public/css');
//    });
//}
