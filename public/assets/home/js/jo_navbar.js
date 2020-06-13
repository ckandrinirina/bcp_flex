/*Textbox Events*/
let style = `
    position: absolute;
    width: 100%;
    top: 0;
    height: 100vh;
    transition: opacity .5s cubic-bezier(0, 0.4, 1, 1);
`;
let backgroundImgHtml = `
    <img style="${style}" class="banner-picture" src="${asset_url}assets/home/images/banner.jpg"/>
    <img style="${style}" class="banner-picture" src="${asset_url}assets/home/images/banner.png"/>
    <img style="${style}" class="banner-picture" src="${asset_url}assets/home/images/Soco_HD-035-big.jpg"/>
`;
$('#banner').append(backgroundImgHtml);
var current = 0,
    slides = $('#banner .banner-picture');

setInterval(function () {
    slides.each((i, el) => {
        $(el).css('opacity', '0');
    })
    current = (current != slides.length - 1) ? current + 1 : 0;
    slides.css('opacity', '0');
    $(slides[current]).css('opacity', '1');
}, 5000);
