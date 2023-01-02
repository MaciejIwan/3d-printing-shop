import { Modal }     from "bootstrap"
import { get, post } from "./ajax"

window.addEventListener('DOMContentLoaded', function () {
    const editCategoryModal = new Modal(document.getElementById('editCategoryModal'))

    document.querySelectorAll('.edit-category-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const categoryId = event.currentTarget.getAttribute('data-id')

            get(`/categories/${ categoryId }`)
                .then(response => openEditCategoryModal(editCategoryModal, response))
        })
    })

    document.querySelector('.save-category-btn').addEventListener('click', function (event) {
        const categoryId = event.currentTarget.getAttribute('data-id')

        post(`/categories/${ categoryId }`, {
            name: editCategoryModal._element.querySelector('input[name="name"]').value
        }).then(response => {
            console.log(response)
            updateTableRow(response['data'])
        })
    })
})

function openEditCategoryModal(modal, {id, name}) {
    const nameInput = modal._element.querySelector('input[name="name"]')

    nameInput.value = name

    modal._element.querySelector('.save-category-btn').setAttribute('data-id', id)

    modal.show()
}

function updateTableRow({id, name, created_at, updated_at}) {
    let date  = new Date();
    document.querySelector(`#categoriesTable > table > tbody > tr.t${id} > td.category-name`).innerHTML = name
    document.querySelector(`#categoriesTable > table > tbody > tr.t${id} > td.category-createAt`).innerHTML = created_at
    document.querySelector(`#categoriesTable > table > tbody > tr.t${id} > td.category-updatedAt`).innerHTML = updated_at
}
