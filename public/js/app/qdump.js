var qdump = angular.module('qdump', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('{%');
    $interpolateProvider.endSymbol('%}');
});

qdump.init = {
    tooltips: function(){
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    }
};

qdump.global = {
    sendNotification: function(message, type){
        $.jnotify(message, {
            type: type,
            delay: 5000
        });
    }
};