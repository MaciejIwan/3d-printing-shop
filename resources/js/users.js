import {Modal} from "bootstrap"
import {get, post} from "./ajax"

window.addEventListener('DOMContentLoaded', function () {
    const editUserModal = new Modal(document.getElementById('editUserModal'))

    document.querySelectorAll('.edit-user-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const userId = event.currentTarget.getAttribute('data-id')

            get(`/users/${userId}`)
                .then(response => openEditUserModal(editUserModal, response))
        })
    })

    document.querySelector('.save-user-btn').addEventListener('click', function (event) {
        const userId = event.currentTarget.getAttribute('data-id')

        post(`/users/${userId}`, {
            name: editUserModal._element.querySelector('input[name="name"]').value,
            email: editUserModal._element.querySelector('input[name="email"]').value,
            role: editUserModal._element.querySelector('select[name="role"]').value
        }).then(response => {
            console.log(response)
            updateTableRow(response['data'])
        })
    })
})

function openEditUserModal(modal, {id, name, email, role}) {
    modal._element.querySelector('input[name="name"]')
        .value = name
    modal._element.querySelector('input[name="email"]')
        .value = email
    modal._element.querySelector('select[name="role"]')
        .value = role;

    modal._element.querySelector('.save-user-btn').setAttribute('data-id', id)

    modal.show()
}

function updateTableRow({id, name, email, role, created_at, updated_at}) {
    console.table([id, name, email, role])
    document.querySelector(`#usersTable > table > tbody > tr.t${id} > td.user-name`).innerHTML = name
    document.querySelector(`#usersTable > table > tbody > tr.t${id} > td.user-email`).innerHTML = email
    document.querySelector(`#usersTable > table > tbody > tr.t${id} > td.user-role`).innerHTML = role
    document.querySelector(`#usersTable > table > tbody > tr.t${id} > td.user-createAt`).innerHTML = created_at
    document.querySelector(`#usersTable > table > tbody > tr.t${id} > td.user-updatedAt`).innerHTML = updated_at
}
