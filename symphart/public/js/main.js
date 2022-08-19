const articles = document.getElementById('articles');

if(articles){
    articles.addEventListener('click', e => {
        if( e.target.className == 'btn btn-danger delete-article'){
            e.preventDefault();
            if( confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');
                fetch(`/article/delete/${id}`, {method: 'DELETE'})
                .then(_ => window.location.reload()
                );
            }
        }
    })
}
