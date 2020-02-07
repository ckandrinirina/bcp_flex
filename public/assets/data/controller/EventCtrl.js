const $datatable = $('#datatable');
$(document).ready(function () {
    initTable('event_json');

    $datatable.on('click', '.deleteAction', function () {
        deleteConfirme($(this).attr('id_element'),'event_delete','event_json');
    })

    $datatable.on('click','.editAction',function (){
        location.href = Routing.generate('event_edit',{id: $(this).attr('id_element')});
    })
});

function initTable(url) {
    $.ajax({
        type: "GET",
        url: Routing.generate(url),
        data: {
            data: 'data'
        },
        success: function (response) {
            table = $datatable.DataTable({
                        data: response,
                        columns: [{
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
                        ],
                        'paging': false,
                        'lengthChange': false,
                        'searching': false,
                        'ordering': false,
                        'info': false,
                        'autoWidth': false,
                        "language": {
                            "emptyTable": "Pas de résultat"
                        },
                        columnDefs: [{
                            targets: [-1],
                            render: function (data, type, row, meta) {
                                return '<button type="button" class="btn btn-primary editAction" id_element="' + row.id + '"><i class="fa fa-edit"></i></button>' +
                                    '<button type="button" class="btn btn-danger deleteAction" id_element="' + row.id + '"><i class="fa fa-times"></i></button>'
                            }
                        }],
            });
        },
        error: function (response) {
            console.log(response);
        }

    });
}

function deleteConfirme(id, urlDel, url) {
    Swal.fire({
        title: 'Voulez-vous supprimer?',
        text: "Cette action est irréversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.value) {
            deleteAction(id, urlDel, url);
        }
    })
}

function deleteAction(id, urlDel, url) {
    $.ajax({
        type: "GET",
        url: Routing.generate(urlDel,{id:id}),
        data: {
            id: id
        },
        success: function (response) {
            Swal.fire(
                'Supprimer!',
                'Supprimer avec succès.',
                'success'
            )
            table.destroy();
            initTable(url);
        }
    });
}