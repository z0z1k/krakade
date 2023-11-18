let payment = document.getElementById('payment-checkbox');
let paymentDiv = document.getElementById('payment-div');

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
function parse(){
    console.log(1);
    let data = {city:document.getElementById('city').value,street:document.getElementById('street').value};
    let placeLocation = document.getElementById("placeLocation").textContent;
    
    axios.post('/api/address/parse', data)
        .then(
                response => {
                  axios.get('/api/address/calc/' + placeLocation + '/' + response.data)
                    .then(response => document.getElementById("distance").innerHTML = Math.round(response.data) / 1000)
                }).catch(
                error => console.log(error)
            )
}