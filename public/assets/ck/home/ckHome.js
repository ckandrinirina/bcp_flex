$(document).ready(() => {
    $('#btn-search').on('click', () => {
        var critere = $('#search').val();
        var proximite = $('#location').val();
        window.location.href(Routing.generate('search_block', {
            'critere': critere,
            'proximite': proximite
        }));
    })
});