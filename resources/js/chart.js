import "../css/index.scss"
import "../css/chart.scss"
import {post, get} from "./ajax"


window.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.decrease-quantity-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            let updateBY = -1
            sendUpdateRequest(event, updateBY);
        })
    })

    document.querySelectorAll('.increase-quantity-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            let updateBY = +1
            sendUpdateRequest(event, updateBY);
        })
    })

    document.querySelectorAll("#cart-submit").forEach(button => {
        button.addEventListener('click', (event) => {
            get(`/chart/submit`, )
                .then(response => console.log(response))
        })
    })


})

function sendUpdateRequest(event, updateBY) {
    const itemId = event.currentTarget.getAttribute('data-id')
    console.log(`data-id: ${itemId}`)

    let currentQuantity = parseInt(event.currentTarget.closest('td').querySelector('.quantity-counter').textContent)
    post(`/chart/${itemId}`, {
        quantity: currentQuantity + updateBY
    }).then(response => {
        console.log(response)
        updateTableRow(response['data'])
    })
}

function updateTableRow({id, name, quantity}) {
    let price = document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.item-price`).innerHTML
    console.log(price + " is the price")
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.item-name`).innerHTML = name
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.item-quantity > span.quantity-counter`).innerHTML = quantity
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.item-total`).innerHTML = parseFloat(parseInt(quantity) * parseFloat(price)).toFixed(2);
}

