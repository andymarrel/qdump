qdump.controller('SettingsController', function($scope){
    $scope.information = {
        changeInformation: function(event, data){
            var token = $('[name="_token"]').val();

            $.ajax('/settings/change/info', {
                type: 'post',
                data: data,
                beforeSend: function(request) {
                    //return request.setRequestHeader('X-CSRF-Token', token);
                },
                success: function(response) {
                    console.log(response);
                    if (response.result === false){
                        if (response.errors.hasOwnProperty('csrf')){
                            qdump.global.sendNotification(response.errors.csrf, "error");
                        }
                    }
                }
            });
        }
    };
});
