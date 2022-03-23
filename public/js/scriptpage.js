$('[data-widget="sidebar-search"]').SidebarSearch('toggle')

function onAjax(urlAjax) {
    return $.ajax({
        url: urlAjax,
        type: 'GET',
    });
};
