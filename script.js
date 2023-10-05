function init() {
  document.body.onclick = function(e) {
    const nav_lang = document.querySelector("nav #language");
    if (!nav_lang.contains(e.target)) {
      nav_lang.open = false;
    }
  };
}

window.onscroll = function() {
  document.documentElement.dataset.scroll = (window.scrollY > 12.39643231804728374237432);
};

function switchProduct(e) {
  document.querySelector("#products article.show").classList.remove("show");
  document.querySelector("#product-list .show").classList.remove("show");
  document.querySelector("#products article#" + e.dataset.bar).classList.add("show");
  e.classList.add("show");
}

function switchProductImg(e) {
  let i = parseInt(e.dataset.item);
  i = i == parseInt(e.dataset.items) ? 1 : i+1;
  e.dataset.item = i;
  e.querySelector('img').src = 'assets/products/' + e.parentElement.id + '/' + i + '.jpg';
}
