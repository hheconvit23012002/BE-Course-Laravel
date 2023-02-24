
function renderPagination(links){
    links.forEach(function(each){
        $('#paginate').append($('<li>').attr('class',`page-item ${each.active ? 'active' : ''}`)
            .append($(`<a class="page-link" href="${each.url}">` +
                `${each.label}`
                + '</a>'))
        )
    })
}
