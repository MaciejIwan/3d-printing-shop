import { Modal }     from "bootstrap"
import { get, post } from "./ajax"

window.addEventListener('DOMContentLoaded', function () {
    const editOrderModal = new Modal(document.getElementById('editOrderModal'))

    document.querySelectorAll('.edit-order-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const orderId = event.currentTarget.getAttribute('data-id')

            get(`/orders/${ orderId }`)
                .then(response => openEditOrderModal(editOrderModal, response))
        })
    })

    document.querySelector('.save-order-btn').addEventListener('click', function (event) {
        const orderId = event.currentTarget.getAttribute('data-id')

        post(`/orders/${ orderId }`, {
            name: editOrderModal._element.querySelector('input[name="name"]').value
        }).then(response => {
            console.log(response)
            updateTableRow(response['data'])
        })
    })
})

function openEditOrderModal(modal, {id, name}) {
    const nameInput = modal._element.querySelector('input[name="name"]')

    nameInput.value = name

    modal._element.querySelector('.save-order-btn').setAttribute('data-id', id)

    modal.show()
}

function updateTableRow({id, name, created_at, updated_at}) {
    let date  = new Date();
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-name`).innerHTML = name
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-createAt`).innerHTML = created_at
    document.querySelector(`#ordersTable > table > tbody > tr.t${id} > td.order-updatedAt`).innerHTML = updated_at
}
