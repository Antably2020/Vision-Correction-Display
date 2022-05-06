// deuteranopia

if (document.getElementById("styleID612481")) {
    stylingID = document.getElementById("styleID612481").remove();
    filterID = document.getElementById("filterID471924").remove();
}
stylingID = document.createElement('style');
stylingID.id = "styleID612481";
document.body.appendChild(stylingID);

filterID = document.createElement('div');
filterID.id = "filterID471924";
filterID.setAttribute('style', 'height: 0; padding: 0; margin: 0; line-height: 0;');
document.body.appendChild(filterID);

filterID.innerHTML = '<svg id="colorblind-filters" style="display: none"> <defs> <filter id="deuteranopia" color-interpolation-filters="linearRGB"> <feColorMatrix type="matrix" values="0.000  0.041  0.555  0.000  0.000    0.000  1.000  0.000  0.000  0.000   0.256  0.170  0.000  0.000  0.000   0.000  0.000  0.000  1.000  0.000" in="SourceGraphic" /> </filter> </defs> </svg>';
stylingID.innerHTML = 'html{-webkit-filter:url(#deuteranopia);-moz-filter:(#deuteranopia);-ms-filter:(#deuteranopia);-o-filter:(#deuteranopia);filter:(#deuteranopia);}'
setTimeout(function() {
    window.scrollBy(1, 1);
    window.scrollBy(-1, -1);
}, 1);

/*



<svg xmlns="http://www.w3.org/2000/svg">
  <filter id="filter">
    <feColorMatrix
      type="matrix"
      values=" 0.000  0.041  0.555  0.000  0.000 
               0.000  1.000  0.000  0.000  0.000 
               0.256  0.170  0.000  0.000  0.000 
               0.000  0.000  0.000  1.000  0.000">
    </feColorMatrix>
  </filter>
</svg>


*/