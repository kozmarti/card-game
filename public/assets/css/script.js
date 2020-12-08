//background
$(function () {
    var body = $('#starshine'),
        template = $('.template.shine'),
        stars = 500,
        sparkle = 20;


    var size = 'small';
    var createStar = function () {
        template.clone().removeAttr('id').css({
            top: (Math.random() * 100) + '%',
            left: (Math.random() * 100) + '%',
            webkitAnimationDelay: (Math.random() * sparkle) + 's',
            mozAnimationDelay: (Math.random() * sparkle) + 's'
        }).addClass(size).appendTo(body);
    };

    for (var i = 0; i < stars; i++) {
        if (i % 2 === 0) {
            size = 'small';
        } else if (i % 3 === 0) {
            size = 'medium';
        } else {
            size = 'large';
        }

        createStar();
    }
});

//game

const cards = document.getElementsByClassName('card');
let imageClickedSrc = '';
let imageClicked = '';
let counter = 0;
let winCount = 0;

for (let i = 0; i < cards.length; i++) {
    cards[i].addEventListener('click', event => {
        let imagePrevious = imageClicked;
        let imagePreviousSrc = imageClickedSrc;
        let clickedPictureId = cards[i].getAttribute('data-id');
        imageClicked = document.getElementById(clickedPictureId);
        imageClickedSrc = imageClicked.src;
        counter += 1;
        if (imagePreviousSrc === imageClickedSrc && imagePrevious !== imageClicked) {
            imageClicked.classList.add('display-block');
            imagePrevious.classList.add('display-block');
            winCount += 2;
            if (winCount === cards.length) {
                alert('Vous avez gagné en ' + counter + ' coups');
            }

        } else if (imagePrevious !== '') {
            imagePrevious.classList.toggle('hidden');
        }
        imageClicked.classList.toggle('hidden')

    })
}
