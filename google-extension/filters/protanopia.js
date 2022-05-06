// protanopia

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

filterID.innerHTML = '<svg id="colorblind-filters" style="display: none"> <defs> <filter id="protanopia" color-interpolation-filters="linearRGB"> <feColorMatrix type="matrix" values="0.000  0.000  1.000  0.000  0.000  0.500  0.500  0.000  0.000  0.000   1.000  0.000  0.000  0.000  0.000   0.000  0.000  0.000  1.000  0.000" in="SourceGraphic" /> </filter> </defs> </svg>';
stylingID.innerHTML = 'html{-webkit-filter:url(#protanopia);-moz-filter:(#protanopia);-ms-filter:(#protanopia);-o-filter:(#protanopia);filter:(#protanopia);}'
setTimeout(function() {
    window.scrollBy(1, 1);
    window.scrollBy(-1, -1);
}, 1);

/*

0.567,0.433,0,0,0 
0.558,0.442,0,0,0  
0,0.242,0.758,0,0
0,0,0,1,        0

1,0,0,1,0  0.4447863,0.1,1.23443,1,0  0,0,1,1,0  0,0,0,1,0


1,0,0,0,0 
0.5, 0.5,0,0,0 
0.25,0,0.25,0,0
0,0,0,1,0



<svg xmlns="http://www.w3.org/2000/svg">
  <filter id="filter">
    <feColorMatrix
      type="matrix"
      values=" 0.000  0.000  1.000  0.000  0.000  0.500  0.500  0.000  0.000  0.000   1.000  0.000  0.000  0.000  0.000   0.000  0.000  0.000  1.000  0.000">
    </feColorMatrix>
  </filter>
</svg>*/
