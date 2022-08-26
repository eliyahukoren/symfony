const authors = document.getElementById('authors');

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

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
