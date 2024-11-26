(function() {
    const header = document.querySelector('.ax-header-menu');
    const throttle=(t,e)=>{let n,o;return function(){const a=this,c=arguments;o?(clearTimeout(n),n=setTimeout((function(){Date.now()-o>=e&&(t.apply(a,c),o=Date.now())}),e-(Date.now()-o))):(t.apply(a,c),o=Date.now())}};
    const handleScroll = function() {
      const scrollPosition = window.scrollY || window.pageYOffset;
      const speed = 0.5;
      
      //banner.style.backgroundPositionY = -(scrollPosition * speed) + 'px';
      if (scrollPosition > 0) {
          header.classList.add("bg-white");
      }
      else {
          header.classList.remove("bg-white");
      }
    }
    window.addEventListener('scroll', throttle(handleScroll, 50));
    window.addEventListener('touchmove', throttle(handleScroll, 50));
})()