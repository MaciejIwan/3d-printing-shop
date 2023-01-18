import "../css/index.scss"

import { Modal }     from "bootstrap"
import { get, post } from "./ajax"


window.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.decrease-quantity-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const orderId = event.currentTarget.getAttribute('data-id')

            get(`/orders/${ orderId }`)
                .then(response => openEditOrderModal(editOrderModal, response))
        })
    })

    document.querySelectorAll('.increase-quantity-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const orderId = event.currentTarget.getAttribute('data-id')

            get(`/orders/${ orderId }`)
                .then(response => openEditOrderModal(editOrderModal, response))
        })
    })
})
