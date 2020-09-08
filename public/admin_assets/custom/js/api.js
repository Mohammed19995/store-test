window.endpoint = get_url;

// admin
window.api_admin_urls = {
    auth : {
        login : endpoint+'/admin/login',
    },
    profile : {
        update : endpoint+'/admin/profile' ,
        change_password : endpoint+"/admin/change-password" ,
    },
    admin : {
        add : endpoint+'/admin/admins' ,
        get_remote : endpoint+'/admin/get-remote-admins',
        execute_option : endpoint+'/admin/admins/execute-option' ,
    },

    user : {
        add : endpoint+'/admin/users' ,
        execute_option : endpoint+'/admin/users/execute-option' ,
    },

    gallery : {
        add : endpoint+'/admin/galleries' ,
        get_remote : endpoint+'/admin/get-remote-galleries' ,
    },
    gallery_types : {
        get_remote : endpoint+'/admin/get-remote-gallery-types' ,
    },

    country : {
        add : endpoint+'/admin/countries' ,
        get_remote : endpoint+'/admin/get-remote-countries',
        execute_option : endpoint+'/admin/countries/execute-option' ,
    },
    category : {
        add : endpoint+'/admin/categories' ,
        get_remote : endpoint+'/admin/get-remote-categories' ,
        execute_option : endpoint+'/admin/categories/execute-option' ,

    },
};

window.api_urls = {
    admin : api_admin_urls ,

};

