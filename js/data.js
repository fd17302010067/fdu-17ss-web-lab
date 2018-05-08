const countries = [
    { name: "Canada", continent: "North America", cities: ["Calgary","Montreal","Toronto"], photos: ["canada1.jpg","canada2.jpg","canada3.jpg"] },
    { name: "United States", continent: "North America", cities: ["Boston","Chicago","New York","Seattle","Washington"], photos: ["us1.jpg","us2.jpg"] },
    { name: "Italy", continent: "Europe", cities: ["Florence","Milan","Naples","Rome"], photos: ["italy1.jpg","italy2.jpg","italy3.jpg","italy4.jpg","italy5.jpg","italy6.jpg"] },
    { name: "Spain", continent: "Europe", cities: ["Almeria","Barcelona","Madrid"], photos: ["spain1.jpg","spain2.jpg"] }
];
window.onload=function() {
    for (var i = 0; i < countries.length; i++) {
        setDiv(countries[i]);
    }

function setDiv(item) {
    var html='';
    html += '<div class="item"><h2>' +item.name+
        '</h2><p>' +item.continent+
        '</p><div class="inner-box"><h3>Cities</h3><ul>';
    for(var i = 0;i <item.cities.length; i++){
        html += '<li>'+item.cities[i]+'</li>';
    }
    html += '</ul></div><div class="inner-box"><h3>Popular Photos</h3>';
    for(var i = 0;i < item.photos.length;i++){
        html += '<img class="photo" src=images/'+item.photos[i]+'>';
    }
    html += '</div><button><p>Visit</p></button></div>';

    var divs = document.getElementsByClassName("flex-container");
    divs[0].innerHTML += html;
}
}
