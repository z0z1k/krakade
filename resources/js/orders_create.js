let payment = document.getElementById('payment-checkbox');
let paymentDiv = document.getElementById('payment-div');

if (payment.checked) {
  paymentDiv.style.display = "block";
}
payment.addEventListener('change', function(){
    if (this.checked) {
        paymentDiv.style.display = "block";
      } else {
        //div.style.visibility = "hidden";
        paymentDiv.style.display = "none";
      }
});

let hard = document.getElementById('hard-checkbox');
let hardDiv = document.getElementById('hard-div');

if (hard.checked) {
  hardDiv.style.display = "block";
}
hard.addEventListener('change', function(){
    if (this.checked) {
        hardDiv.style.display = "block";
      } else {
        //div.style.visibility = "hidden";
        hardDiv.style.display = "none";
      }
});

function stopDefAction(evt) {
    evt.preventDefault();
}

let addressBtn = document.getElementById("addressBtn");
let city = document.getElementById('city');
let street = document.getElementById('street');
city.addEventListener("change", parse);
street.addEventListener("change", parse);

let loader = document.querySelector('.loader');
function parse(){
    loader.style.display = 'block';
    let select = document.getElementById('city');
    let options = select.options;
    let city = select.options[select.value-1].textContent;
    
    let data = {city:city,street:document.getElementById('street').value};
    let placeLocation = document.getElementById("placeLocation").textContent;
    
    axios.post('/api/address/parse', data)
        .then(
                response => {
                  document.getElementById("location-input").value = response.data;
                  document.getElementById("map").innerHTML = 
                  "<img width='600' height='400' src='https://maps.geoapify.com/v1/staticmap?style=osm-carto&width=600&height=400&center=lonlat:" + response.data + "&zoom=14&marker=lonlat:" + response.data + ";color:%23ff0000;size:small&apiKey=593087ab22f34ff9864cdc6579caf776'>";
                  console.log(response.data);
                  axios.get('/api/address/calc/' + placeLocation + '/' + response.data)
                    .then(response => document.getElementById("distance").innerHTML = Math.round(response.data) / 1000) + 'км'; loader.style.display = 'none'
                }).catch(
                error => console.log(error)
            )
}