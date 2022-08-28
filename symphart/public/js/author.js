const authors = document.getElementById('authors');
const searchBtn = document.getElementById('searchBtn');
const searchForm = document.getElementById('searchForm');

if (authors) {
    authors.addEventListener('click', e => {
        if (e.target.className == 'btn btn-danger delete-author') {
            e.preventDefault();
            if (confirm('Are you sure about delete author?')) {
                const id = e.target.getAttribute('data-id');
                fetch(`/author/delete/${id}`, { method: 'DELETE' })
                    .then(_ => window.location.reload()
                    );
            }
        }
    })
}

searchBtn.addEventListener('keyup', e => {
    let x = setTimeout(() => {
        searchForm.submit()
    }, 500)
})

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
searchBtn.focus()
