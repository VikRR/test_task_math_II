let news = document.querySelectorAll('.news'),
    mql = window.matchMedia('all and (max-width: 1024px)');

let handleMatchMedia = function (mediaQuery) {
        if (mediaQuery.matches) {
            for (let i = 0; i < news.length; i++) {
                if(i === 0 || i === 3){
                    news[i].classList.add('big');
                }
            }
        } else {
            for (let i = 0; i < news.length; i++) {
                if(i === 2 || i === 5){
                    news[i].classList.add('big');
                }
            }
        }
    };

handleMatchMedia(mql);

mql.addListener(handleMatchMedia);