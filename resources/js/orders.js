import "../css/index.scss"
import "../css/orders.scss"

import {Modal} from "bootstrap"
import {get, post} from "./ajax"


window.addEventListener('DOMContentLoaded', function () {
    const editOrderModal = new Modal(document.getElementById('editOrderModal'))

    document.querySelectorAll('.edit-order-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const orderId = event.currentTarget.getAttribute('data-id')

            get(`/orders/${orderId}`)
                .then(response => {
                    openEditOrderModal(editOrderModal, response)
                })
        })
    });

    document.querySelector('.save-order-btn').addEventListener('click', function (event) {
        const orderId = event.currentTarget.getAttribute('data-id')

        post(`/orders/${orderId}`, {
            name: editOrderModal._element.querySelector('input[name="name"]').value,
            status: editOrderModal._element.querySelector('select[name="status"]').value,
            is_paid: editOrderModal._element.querySelector('select[name="payment-status"]').value,
        }).then(response => {
            updateTableRow(response['data'])
        })
    })

    document.querySelectorAll('.expand-order-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            let orderId = this.dataset.id;
            let orderDetailsRow = document.querySelector(`.order-${orderId}`);
            orderDetailsRow.classList.toggle("d-none");
            this.classList.toggle("arrow-up");
            this.classList.toggle("arrow-down");
        });
    });
})

function openEditOrderModal(modal, {id, status, name, is_paid}) {
    const nameInput = modal._element.querySelector('input[name="name"]')
    const statusInput = modal._element.querySelector('select[name="status"]')
    const paymentInput = modal._element.querySelector('select[name="payment-status"]')

    nameInput.value = name
    statusInput.value = status
    paymentInput.value = is_paid

    modal._element.querySelector('.save-order-btn').setAttribute('data-id', id)


    modal.show()
}

function updateTableRow({id, status, is_paid, created_at, updated_at}) {
    let date = new Date();
    console.log(id, status, is_paid, created_at, updated_at)
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-name`).innerHTML = id
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-status`).innerHTML = status
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-paid`).innerHTML = is_paid
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-createAt`).innerHTML = created_at
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-updatedAt`).innerHTML = updated_at

}
