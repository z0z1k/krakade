ajaxGetOrders('/api/activeOrders.php');

    setInterval(
        () => ajaxGetOrders('/api/activeOrders.php'),
        20000
    );

    function generateRow (row) {
        let address = `<p class="card-text">${row.client_address}</p>`;
        let phone = `<p class="card-text">${row.client_phone}</p>`;
        let beReady = `<p class="card-text">${row.beReady}</p>`;
        let payment = `<p class="card-text">${row.paymentType}</p>`;
        let comment = `<p class="card-text">${row.orderComent}</p>`;
        let dt_get = row.dt_get;
        let courier = `<p class="card-text">${row.courier}</p>`;
        let edit = `<p class="card-text"><a href="/edit/${row.order_id}">Редагувати замовлення</a></p>`;
        let cancel = `<p class="card-text"><a href="/ready/${row.order_id}">Скасувати замовлення</a></p>`;
        let hr = `<hr>`;

        let result = `<div class="row"><div class="col">${address}${phone}${beReady}${payment}${comment}${dt_get}${courier}${edit}${cancel}${hr}</div></div>`;
        return result;
    }

    function ajaxGetOrders(url) {
        let request = new XMLHttpRequest();
        document.querySelector('#ordersList').innerHTML = `<h4>Активні замовлення:</h4>`;

        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                let orders = JSON.parse(request.responseText);
                orders.forEach(element => {
                    document.querySelector('#ordersList').innerHTML += generateRow(element);
                });
            }
        }

        request.open('POST', url);
        request.send();
    }
