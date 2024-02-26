function setupCheckboxListener(checkboxId, divId) {
    let checkbox = document.getElementById(checkboxId);
    let div = document.getElementById(divId);

    function toggleDivDisplay() {
        div.style.display = checkbox.checked ? "block" : "none";
    }

    toggleDivDisplay(); // Initial setup
    checkbox.addEventListener('change', toggleDivDisplay);
}

function setupAddressParser() {
    let city = document.getElementById('city');
    let street = document.getElementById('street');
    let loader = document.querySelector('.loader');

    function parseAddress() {
        loader.style.display = 'block';
        let selectedCity = city.options[city.value - 1].textContent;
        let data = { city: selectedCity, street: street.value };
        let placeLocation = document.getElementById("placeLocation").textContent;

        axios.post('/api/address/parse', data)
            .then(response => {
                axios.get('/api/address/calc/' + placeLocation + '/' + response.data)
                    .then(response => {
                        document.getElementById("distance").value = response.data;
                        loader.style.display = 'none';
                    })
                    .catch(error => console.log(error));
            })
            .catch(error => console.log(error));
    }

    city.addEventListener("change", parseAddress);
    street.addEventListener("change", parseAddress);

    if (street.value !== '') {
        parseAddress();
    }
}

setupCheckboxListener('payment-checkbox', 'payment-div');
setupCheckboxListener('hard-checkbox', 'hard-div');
setupAddressParser();
