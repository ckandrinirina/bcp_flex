app.controller('EventCtrl',['$scope','$http', function($scope,$http) {
    const $eventTable = $('#eventTable');

    this.$onInit = function(){
        initTable();
    }

    function initTable(){
        $http({
            method:'GET',
            url:Routing.generate('event_json')
        }).then(function success(response){
            $eventTable.DataTable({
                data: response.data,
                columns: [
                    { data: 'id' },
                    { data: 'nom' },
                    { data: 'presentation' },
                    { data: 'date' },
                    { data: 'place' }
                ],
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : false,
                "language": {
                    "emptyTable":     "Pas de résultat"
                }
            });
        },function error(response){
            console.log(response);
        })
    }
}]);