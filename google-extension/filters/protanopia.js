// protanopia

if (document.getElementById("styleID")) {
    stylingID = document.getElementById("styleID").remove();
    filterID = document.getElementById("filterID").remove();
}
stylingID = document.createElement('style');
stylingID.id = "styleID";
document.body.appendChild(stylingID);

filterID = document.createElement('div');
filterID.id = "filterIDnew";
filterID.setAttribute('style', 'height: 0; padding: 0; margin: 0; line-height: 0;');
document.body.appendChild(filterID);

filterID.innerHTML = '<svg id="colorblind-filters" style="display: none"> <defs> <filter id="protanopia" color-interpolation-filters="linearRGB"> <feColorMatrix type="matrix" values="0.041  0.000  0.556  0.000  0.000  0.172  0.264  0.000  0.000  0.000   1.000  0.000  0.000  0.000  0.000  0.000  0.000  0.000  1.000  0.000" in="SourceGraphic" /> </filter> </defs> </svg>';
stylingID.innerHTML = 'html{-webkit-filter:url(#protanopia);-moz-filter:(#protanopia);-ms-filter:(#protanopia);-o-filter:(#protanopia);filter:(#protanopia);}'
setTimeout(function() {
    window.scrollBy(1, 1);
    window.scrollBy(-1, -1);
}, 1);

/*

<svg xmlns="http://www.w3.org/2000/svg">
  <filter id="filter">
    <feColorMatrix
      type="matrix"
      values=" 0.041  0.000  0.556  0.000  0.000 
               0.172  0.264  0.000  0.000  0.000 
               1.000  0.000  0.000  0.000  0.000 
               0.000  0.000  0.000  1.000  0.000">
    </feColorMatrix>
  </filter>
</svg>*/