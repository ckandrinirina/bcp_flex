$(document).ready(() => {
    $('#btn-search').on('click', () => {
        var critere = $('#search').val();
        var proximite = $('#location').val();
        window.location.replace(Routing.generate('search_block', {
            'critere': critere,
            'proximite': proximite
        }));
    })
});