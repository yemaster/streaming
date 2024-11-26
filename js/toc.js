document.addEventListener("DOMContentLoaded", function() {
    const headers = document.querySelectorAll("#article-main h1,#article-main h2,#article-main h3,#article-main h4,#article-main h5,#article-main h6");
    const tocItems = [];
    const axToc = document.getElementById("ax-toc");
    axToc.innerHTML = "";
    
    const remValue = 5.5 * parseFloat(getComputedStyle(document.documentElement).fontSize);
    
    let cnt = 0;
    let initScroll = null;
    for (const ele of headers) {
        cnt += 1;
        ele.id = `ax-header-${cnt}`;
        const tocItem = document.createElement('div');
        tocItem.classList.add('ax-toc-item', `ax-toc-${ele.tagName.toLowerCase()}`);
        tocItem.innerText = ele.innerText;
        tocItem.addEventListener("click", () => {
            const targetTop = ele.getBoundingClientRect().top;
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            const targetScrollPosition = currentScroll + targetTop - remValue;
            
            location.hash = `go-${ele.id}`;

            window.scrollTo({
                top: targetScrollPosition,
                behavior: 'smooth' // 平滑滚动
            });
        });
        /*ele.addEventListener("click", () => {
            tocItem.click();
        });*/
        if (location.hash === `#go-${ele.id}`) {
            tocItem.click();
        }
        tocItems.push(tocItem);
        axToc.appendChild(tocItem);
    }

    const throttle = (fn, wait) => {
        let lastTime = 0;
        return function(...args) {
            const now = Date.now();
            if (now - lastTime >= wait) {
                lastTime = now;
                fn.apply(this, args);
            }
        };
    };
    
    let nowActive = -1;

    function handleScrollToc() {
        let activeEle = -1;
        let maxDistance = -Infinity;

        // 找到离顶部最近且小于 remValue 的元素
        for (let i = 0; i < headers.length; ++i) {
            const distanceFromTop = headers[i].getBoundingClientRect().top - 5;
            if (distanceFromTop <= remValue && distanceFromTop > maxDistance) {
                activeEle = i;
                maxDistance = distanceFromTop;
            }
        }

        // 只更新需要更新的 tocItem
        if (activeEle !== -1 && !tocItems[activeEle].classList.contains('active')) {
            if (nowActive != -1) {
                tocItems[nowActive].classList.remove("active");
            }
            nowActive = activeEle;
            tocItems[activeEle].classList.add('active');

            // 只在需要时滚动 toc
            const targetOffsetTop = tocItems[activeEle].offsetTop;
            const tocHeight = axToc.clientHeight;
            const currentScroll = axToc.scrollTop;
            
            if (targetOffsetTop < currentScroll || targetOffsetTop >= currentScroll + tocHeight) {
                axToc.scrollTo({
                    top: targetOffsetTop,
                    behavior: 'smooth'
                });
            }
        }
    }

    // 优化: 将 scroll 和 touchmove 的节流时间统一调整为 50ms
    window.addEventListener('scroll', throttle(handleScrollToc, 50));
});
