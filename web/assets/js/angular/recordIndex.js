var recordApp = angular.module('recordApp', [
    'newsIndexCtrl',
    'treeControl',
    'treeService',
    'newsService',
    'ui.grid',
    'ui.grid.selection',
    'xeditable',
    'angularFileUpload',
    'flow',
    'ngCkeditor',
    'ui.bootstrap',
    'ui.bootstrap.modal',
    'ngSanitize'
]);


recordApp.config(['flowFactoryProvider', function (flowFactoryProvider) {
    flowFactoryProvider.defaults = {
        target: 'upload.php',
        permanentErrors: [404, 500, 501],
        maxChunkRetries: 1,
        chunkRetryInterval: 5000,
        simultaneousUploads: 4,
        singleFile: true
    };
    flowFactoryProvider.on('catchAll', function (event) {
        console.log('catchAll', arguments);
    });
    // Can be used with different implementations of Flow.js
    // flowFactoryProvider.factory = fustyFlowFactory;
}]);

recordApp.run(function(editableOptions){
    editableOptions.theme = 'bs3';
});
