url = 'event_json';
urlDel = 'event_delete'
urlEdit = 'event_edit'
columns = [{
        data: 'nom'
    },
    {
        data: 'presentation'
    },
    {
        data: 'date'
    },
    {
        data: 'place'
    },
    {
        data: 'actions'
    }
]

$(document).ready(function () {
    initTable();
    pagination();
    initAction();
});