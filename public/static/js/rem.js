(function (w,d) {
    function resizeRem() {
        var html  = d.getElementsByTagName("html")[0],
            width = d.body.clientWidth;
             console.log(width)
        width = width > 750  ? 750 : width;
        html.style.fontSize = (width / 22.5) + 'px';


         console.log(html.style.fontSize)
         console.log(html.style.width)
    }
    resizeRem();
    window.addEventListener('resize',resizeRem,false);
})(window,document);