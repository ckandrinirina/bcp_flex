$(document).ready(() => {
    $('#btn-search').on('click', () => {
        var critere = $('#search').val();
        var proximite = $('#location').val();
        window.location.replace(Routing.generate('search_block', {
            'type':'restaurant',
            'critere': critere,
            'proximite': proximite
        }));
    })
});