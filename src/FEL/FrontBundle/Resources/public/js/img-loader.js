$('section').click(function(e){
    $(e.currentTarget).find(".img-loader").each(function(i, e){
        data=JSON.parse(e.innerHTML);
        e.innerHTML='<img src="'+data.src+'" alt="'+data.alt+'" />';
        $(e).removeClass("img-loader");
    });
});
