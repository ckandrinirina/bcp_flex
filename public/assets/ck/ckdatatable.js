//=============================================ck datatable//
const $datatable = $('#datatable');
limit = 5;
offset = 0;
search = '';

function initAction() {
    $datatable.on('click', '.deleteAction', function () {
        deleteConfirme($(this).attr('id_element'));
    })

    $datatable.on('click', '.editAction', function () {
        location.href = Routing.generate(urlEdit, {
            id: $(this).attr('id_element')
        });
    })

    $('.search').keyup(function () { 
        search = $(this).val();
    });
}

function pagination() {
    $('.next').on('click', function () {
        offset = offset + limit;
        $('.previous').attr('disabled', false);
        if (offset >= total) {
            $('.next').attr('disabled', true);
            offset = offset - limit;
        } else {
            table.destroy();
            initTable();
        }
    })

    $('.previous').on('click', function () {
        offset = offset - limit;
        $('.next').attr('disabled', false);
        if (offset >= 0) {
            table.destroy();
            initTable();
        } else {
            $('.previous').attr('disabled', true);
            offset = offset + limit;
        }
    })

    $('.doSearch').on('click',function(){
        table.destroy();
        initTable();
    })
}

function initTable() {
    $.ajax({
        type: "GET",
        url: Routing.generate(url, {
            'limit': limit,
            'offset': offset,
            'search': search,
        }),
        success: function (response) {
            total = response.count;
            table = $datatable.DataTable({
                data: response.data,
                columns: columns,
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

function deleteConfirme(id) {
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
            deleteAction(id);
        }
    })
}

function deleteAction(id) {
    $.ajax({
        type: "GET",
        url: Routing.generate(urlDel, {
            id: id
        }),
        success: function (response) {
            Swal.fire(
                'Supprimer!',
                'Supprimer avec succès.',
                'success'
            )
            table.destroy();
            initTable();
        }
    });
}